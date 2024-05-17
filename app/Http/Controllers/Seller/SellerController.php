<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\GatewayConfiguration;
use App\Models\Participant;
use App\Models\Raffle;
use App\Models\RaffleAward;
use App\Models\RaffleImage;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Intervention\Image\Facades\Image;

class SellerController extends Controller
{

    public function index()
    {
        $user = Auth::user();

        $data = $user->raffles()->orderBy('id')->paginate();

        $data['total_raffles_active'] = $user->raffles()->where('status', 'Ativo')->count();
        $data['total_raffles_finished'] = $user->raffles()->where('status', 'Encerrado')->count();
        $data['total_raffles'] = $user->raffles()->count();

        foreach ($data['data'] as $key => $value) {
            $raffle = $user->raffles()->ofId($value['id'])->first();
            $data['data'][$key]['paid'] = $raffle->participants()->sum('paid');
        }

        return Inertia::render('Seller/Raffle/RaffleIndex', ['data' => $data]);
    }

    public function view(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user) {
            return Inertia::render('Auth/Login');
        }

        $raffle = $user->raffles()->ofId($id)->first();

        $data['raffle'] = $raffle ? $raffle : '';

        $data['grafics'] = [
            'participants' => $raffle->participants()->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(DISTINCT document) as value'))
                ->groupBy(DB::raw('DATE(created_at)'))->get(),

            'paid' => $raffle->participants()->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(paid) as value'))
                ->groupBy(DB::raw('DATE(created_at)'))->get(),

            'expired' => $raffle->participants()->select(DB::raw('DATE(created_at) as date'), DB::raw('(SUM(reserved) - SUM(paid)) as value'))
                ->groupBy(DB::raw('DATE(created_at)'))->get()
        ];

        $data['participants']['data'] = $raffle->participants()->orderBy('id')->paginate();

        $data['participants']['distinct'] = $raffle->participants()->select('document')->distinct('document')->count();
        $data['participants']['ranking'] = $raffle->participants()->select('document', 'name', 'email', DB::raw('COUNT(*) as quantity'), DB::raw('SUM(amount) as total_value'))->groupBy('document', 'name', 'email')->orderByDesc('total_value')->take(3)->get();

        $data['raffle']['image'] = $raffle->raffle_images()->first();
        $data['raffle']['paid'] = $raffle->participants()->sum('paid');

        // dd('Aqui');
        return Inertia::render('Seller/Raffle/RaffleView', ['data' => $data]);
    }

    public function created(Request $request)
    {

        $data['quantity_numbers'] = [
            ['value' => 100, 'texto' => '100 cotas - (0 à 99)'],
            ['value' => 1000, 'texto' => '1.000 cotas - (0 à 999)', 'selected' => true],
            ['value' => 10000, 'texto' => '10.000 cotas - (0 à 9.999)'],
            ['value' => 100000, 'texto' => '100.000 cotas - (0 à 99.999)'],
            ['value' => 1000000, 'texto' => '1.000.000 cotas - (0 à 999.999)'],
            ['value' => 10000000, 'texto' => '10.000.000 cotas - (0 à 9.999.999)']
        ];

        $gateway = GatewayConfiguration::join('gateways', 'gateways.id', 'gateway_configurations.gateway_id')->where('user_id', auth()->user()->id)->get();
        if($gateway->isEmpty()) return Inertia::render('Seller/Raffle/RaffleCreate')->with(['message' => 'Configure o gateway para inserir uma rifa']);

        //$data['gateway'] = $gateway;

        return Inertia::render('Seller/Raffle/RaffleCreate', $data);
    }

    public function store(Request $request)
    {
        //dd($request->all());
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|min:10|max:255',
            'subtitle' => 'required|string|min:5|max:255',
            'pix_expired' => 'required',
            'buyer_ranking' => 'required',
            'link' => 'required',
            'price' => 'required|numeric|gt:0',
            'status' => 'required',
            'total' => 'required',
            'type' => 'required',
            'highlight' => 'required',
            'minimum_purchase' => 'required',
            'maximum_purchase' => 'required',
            //'visible' => 'required',
            'description' => 'required',
            //'gateway_id' => 'required',
            'banner' => 'required_if:highlight,true|image|nullable|max:2048', //|dimensions:max_width=768,max_height=560',
            'partial' => 'required',
            'expected_date' => 'required|date|after:today',
            'awards' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->messages()], 403);
        }

        $user_id =  auth()->user()->id;
        $link = $request->link;

        $exitsSlug = Raffle::Slug($link)->UserID($user_id)->first();
        if($exitsSlug){
            $num = rand(100,999);
            $string = Str::random(4);
            $link = $link.'-'.$num.$string;
        }

        $numbers = numbers_generate($request->total);
        $price = (int)($request->price*100);
        $total = $price*$request->total;

        if($request->file('banner')){
            $name = (string) Str::uuid();
            $webp = (string) Image::make($request->file('banner'))->fit(768, 560, function ($constraint) {
                $constraint->upsize();
            })->encode('webp', 95);
            $path = config('filesystems.disks.s3.path').'/images/'.$user_id.'/banner/'.$name.'.webp';

            $image = Storage::disk(config('filesystems.default'))->put($path, $webp);
        }

        DB::beginTransaction();
        try {

            $rifa = Raffle::create([
                'title' => $request->title,
                'subtitle' => $request->subtitle,
                'pix_expired' => $request->pix_expired,
                'buyer_ranking' => $request->buyer_ranking,
                'link' => $link,
                'price' => $price,
                'status' => $request->status,
                'quantity' => $request->total,
                'numbers' => $numbers,
                'type' => $request->type,
                'highlight' => $request->highlight,
                'minimum_purchase' => $request->minimum_purchase,
                'maximum_purchase' => $request->maximum_purchase,
                'visible' => !empty($request->visible) ? true : false,
                'user_id' => $user_id,
                'partial' => $request->partial,
                'description' => $request->description,
                'video' => null,
                'gateway_id' => 1, //Padrao PIXCRED
                'total' => $total,
                'banner' => !empty($image) ? $path : null,
                'expected_date' => $request->expected_date
            ]);

            if(!empty($rifa->id)){
                if(!empty($request->awards)){
                    $raffleAwards = [];
                    foreach ($request->awards as $key => $item){
                        $order = $key+1;
                        $raffleAwards[] = [
                            'order' => $order,
                            'description' => $item['description'],
                            'raffle_id' => $rifa->id
                        ];
                    }
                    if(!empty($raffleAwards)) RaffleAward::insert($raffleAwards);
                }else{
                    setLogErros('SellerController', 'Erro Rifa Insert Awards', [$request->all(), $rifa]);
                    DB::rollBack();
                    return response()->json(['message' => 'Problema ao inserir a rifa, verifique os campos!'], 403);
                }

                if(!empty($request->gallery)){
                    $raffleImages = [];
                    foreach ($request->gallery as $key => $item){
                        $glr = explode(';base64,', $item['image']);

                        $name = (string) Str::uuid();
                        $webp = (string) Image::make(base64_decode($glr[1]))->fit(500, 500, function ($constraint) {
                            $constraint->upsize();
                        })->encode('webp', 95);
                        $path = config('filesystems.disks.s3.path').'/images/'.$user_id.'/gallery/'.$rifa->id.'/'.$name.'.webp';

                        $image = Storage::disk(config('filesystems.default'))->put($path, $webp);

                        if($image){
                            $highlight = $key == 0 ? 1 : 0;
                            $raffleImages[] = [
                                'highlight' => $highlight,
                                'path' => $path,
                                'raffle_id' => $rifa->id
                            ];
                        }
                    }
                    if(!empty($raffleImages)) RaffleImage::insert($raffleImages);
                }
            }else{
                setLogErros('SellerController', 'Erro Rifa Insert', $request->all());
                DB::rollBack();
                return response()->json(['message' => 'Problema ao inserir a rifa, verifique os campos!'], 403);
            }

            DB::commit();

            return $this->index();
        }catch (QueryException $e){
            setLogErros('SellerController', $e->getMessage(), $request->all());
            DB::rollBack();
            return response()->json(['message' => 'Problema ao inserir a rifa, verifique os campos!'], 403);
        }
    }

    public function updated(Request $request, $id)
    {
        $user = Auth::user();
        $raffle = $user->raffles()->findOrFail($id);

        if (!$raffle) {
            return redirect()->back()->with('error', 'Rifa não encontrada!.');
        }

        $raffle->update([
            'status' => 'Encerrado',
            'updated_at' => now(),
            'visible' => 0
        ]);
        return redirect()->back()->with('success', 'Rifa encerrada com sucesso.');
    }
}
