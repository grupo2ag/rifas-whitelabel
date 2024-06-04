<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Charge;
use App\Models\GatewayConfiguration;
use App\Models\Participant;
use App\Models\Raffle;
use App\Models\RaffleAward;
use App\Models\RaffleImage;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Intervention\Image\Facades\Image;
use Spatie\SimpleExcel\SimpleExcelWriter;


class SellerController extends Controller
{

    public function index()
    {
        $user = auth()->user();

        $gateway = $user->gatewayConfigurations()->first();

        if (empty($gateway->token) || empty($gateway->login)) {
            return redirect()->route('paymentMethods')->with('message', 'Primeiro passo configure o Gateway')->send();
        }

        $data = $user->raffles()->orderBy('id')->paginate()->toArray();

        $data['total_raffles_active'] = $user->raffles()->where('status', 'Ativo')->count();
        $data['total_raffles_finished'] = $user->raffles()->where('status', 'Finalizado')->count();
        $data['total_raffles'] = $user->raffles()->count();

        foreach ($data['data'] as $key => $value) {

            $raffle = $user->raffles()->ofId($value['id'])->first();
            $data['data'][$key]['paid'] = $raffle->participants()->sum('paid');
            $image = $raffle->raffle_images()->first();

            if (!empty($image))
                $data['data'][$key]['image'] = Storage::disk(config('filesystems.default'))->temporaryUrl($image->path, now()->addMinutes(30));
        }

        return Inertia::render('Seller/Raffle/RaffleIndex', ['data' => $data]);
    }

    public function view($id)
    {
        $user = auth()->user();

        $raffle = $user->raffles()->ofId($id)->first();

        $data['raffle'] = $raffle ? $raffle : '';

        $data['grafics'] = [
            'participants' => $raffle->participants()->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(DISTINCT document) as value'))
                ->groupBy(DB::raw('DATE(created_at)'))->get(),

            'paid' => $raffle->participants()->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(paid) as value'))
                ->groupBy(DB::raw('DATE(created_at)'))->get(),

            'reserved' => $raffle->participants()->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(reserved) as value'))
                ->groupBy(DB::raw('DATE(created_at)'))->get()
        ];

        $data['participants']['data'] = $raffle->participants()->orderBy('id')->where('paid', '>', 0)->paginate();

        if ($data['raffle']['type'] === 'manual') {
            $data['participants']['reserved'] = $raffle->participants()->orderBy('id')->where('reserved', '>', 0)->paginate();
        }

        $data['participants']['distinct'] = $raffle->participants()->select('document')->distinct('customer_id')->count();
        $data['participants']['ranking'] = $raffle->participants()->select('document', 'name', 'email', DB::raw('COUNT(*) as quantity'), DB::raw('SUM(amount) as total_value'))->groupBy('document', 'name', 'email')->orderByDesc('total_value')->take(3)->get();

        $data['raffle']['paid'] = $raffle->participants()->sum('paid');
        $data['raffle']['reserved'] = $raffle->participants()->sum('reserved');
        $image = $raffle->raffle_images()->first();

        if (!empty($image)) {
            $data['raffle']['image'] = Storage::disk(config('filesystems.default'))->temporaryUrl($image->path, now()->addMinutes(30));
        }
        $data['user_configurations'] = $user->userConfigurations()->first();

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
        if ($gateway->isEmpty())
            return Inertia::render('Seller/Raffle/RaffleCreate')->with(['message' => 'Configure o gateway para inserir uma rifa']);

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
            'value' => 'required|numeric|gt:0',
            'status' => 'required',
            'quantity' => 'required',
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

        $user_id = auth()->user()->id;
        $link = $request->link;

        $exitsSlug = Raffle::Slug($link)->UserID($user_id)->first();
        if ($exitsSlug) {
            $num = rand(100, 999);
            $string = Str::random(4);
            $link = $link . '-' . $num . $string;
        }

        $numbers = numbers_generate($request->quantity);
        $price = (int) ($request->value * 100);
        $total = $price * $request->quantity;

        if ($request->file('banner')) {
            $name = (string) Str::uuid();
            $webp = (string) Image::make($request->file('banner'))->fit(768, 560, function ($constraint) {
                $constraint->upsize();
            })->encode('webp', 95);
            $path = config('filesystems.disks.s3.path') . '/images/' . $user_id . '/banner/' . $name . '.webp';

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
                'quantity' => $request->quantity,
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

            if (!empty($rifa->id)) {
                if (!empty($request->awards)) {
                    $raffleAwards = [];
                    foreach ($request->awards as $key => $item) {
                        $order = $key + 1;
                        $raffleAwards[] = [
                            'order' => $order,
                            'description' => $item['description'],
                            'raffle_id' => $rifa->id
                        ];
                    }
                    if (!empty($raffleAwards))
                        RaffleAward::insert($raffleAwards);
                } else {
                    DB::rollBack();
                    setLogErros('SellerController', 'Erro Rifa Insert Awards', [$request->all(), $rifa]);
                    return response()->json(['message' => 'Problema ao inserir a rifa, verifique os campos!'], 403);
                }

                if (!empty($request->gallery)) {
                    $raffleImages = [];
                    foreach ($request->gallery as $key => $item) {
                        $glr = explode(';base64,', $item['image']);

                        $name = (string) Str::uuid();
                        $webp = (string) Image::make(base64_decode($glr[1]))->fit(500, 500, function ($constraint) {
                            $constraint->upsize();
                        })->encode('webp', 95);
                        $path = config('filesystems.disks.s3.path') . '/images/' . $user_id . '/gallery/' . $rifa->id . '/' . $name . '.webp';

                        $image = Storage::disk(config('filesystems.default'))->put($path, $webp);

                        if ($image) {
                            $highlight = $key == 0 ? 1 : 0;
                            $raffleImages[] = [
                                'highlight' => $highlight,
                                'path' => $path,
                                'raffle_id' => $rifa->id
                            ];
                        }
                    }
                    if (!empty($raffleImages))
                        RaffleImage::insert($raffleImages);
                }
            } else {
                DB::rollBack();
                setLogErros('SellerController', 'Erro Rifa Insert', $request->all());
                return response()->json(['message' => 'Problema ao inserir a rifa, verifique os campos!'], 403);
            }

            DB::commit();

            return $this->index();
        } catch (QueryException $e) {
            DB::rollBack();
            setLogErros('SellerController', $e->getMessage(), $request->all());
            return response()->json(['message' => 'Problema ao inserir a rifa, verifique os campos!'], 403);
        }
    }

    public function updated(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'string',
            'visible' => 'string'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->messages()], 403);
        }

        $user = auth()->user();
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

    public function update(Request $request)
    {
        //dd($request->all());
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:raffles,id',
            'title' => 'required|string|min:10|max:255',
            'subtitle' => 'required|string|min:5|max:255',
            'pix_expired' => 'required',
            'buyer_ranking' => 'required',
            'link' => 'required',
            'value' => 'required|numeric|gt:0',
            'status' => 'required',
            'quantity' => 'required',
            //'type' => 'required',
            'highlight' => 'required',
            'minimum_purchase' => 'required',
            'maximum_purchase' => 'required',
            //'visible' => 'required',
            'description' => 'required',
            //'gateway_id' => 'required',
            'banner' => 'required_if:highlight,true|image|nullable|max:2048', //|dimensions:max_width=768,max_height=560',
            'partial' => 'required',
            'awards' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->messages()], 403);
        }

        $user = auth()->user();

        $raffle = $user->raffles()->ofId($request->id)->first();

        $user_id = $user->id;
        $link = $request->link;

        $exitsSlug = Raffle::Slug($link)->UserID($user_id)->where('id', '<>', $raffle->id)->first();
        if ($exitsSlug) {
            $num = rand(100, 999);
            $string = Str::random(4);
            $link = $link . '-' . $num . $string;
        }

        $price = (int)$request->value;
        $total = $price * $request->quantity;

        if ($request->file('banner')) {
            $name = (string) Str::uuid();
            $webp = (string) Image::make($request->file('banner'))->fit(768, 560, function ($constraint) {
                $constraint->upsize();
            })->encode('webp', 95);
            $path = config('filesystems.disks.s3.path') . '/images/' . $user_id . '/banner/' . $name . '.webp';

            $image = Storage::disk(config('filesystems.default'))->put($path, $webp);
        }

        DB::beginTransaction();
        try {
            //dd($price);
            $raffle->title = $request->title;
            $raffle->subtitle = $request->subtitle;
            $raffle->pix_expired = $request->pix_expired;
            $raffle->buyer_ranking = $request->buyer_ranking;
            $raffle->link = $link;
            $raffle->price = $price;
            $raffle->status = $request->status;
            $raffle->quantity = $request->quantity;
            $raffle->highlight = $request->highlight;
            $raffle->minimum_purchase = $request->minimum_purchase;
            $raffle->maximum_purchase = $request->maximum_purchase;
            //$raffle->visible = !empty($request->visible) ? true : false;
            $raffle->user_id = $user_id;
            $raffle->partial = $request->partial;
            $raffle->description = $request->description;
            $raffle->total = $total;
            $raffle->banner = !empty($image) ? $path : null;

            $raffle->save();

                if (!empty($request->awards)) {
                    RaffleAward::where('raffle_id', $raffle->id)->delete();
                    $raffleAwards = [];
                    foreach ($request->awards as $key => $item) {
                        $order = $key + 1;
                        $raffleAwards[] = [
                            'order' => $order,
                            'description' => $item['description'],
                            'raffle_id' => $raffle->id
                        ];
                    }
                    if (!empty($raffleAwards))
                        RaffleAward::insert($raffleAwards);
                } else {
                    DB::rollBack();
                    setLogErros('SellerController', 'Erro Rifa Update Awards', [$request->all(), $raffle]);
                    return response()->json(['message' => 'Problema ao atualizar a rifa, verifique os campos!'], 403);
                }

                if (!empty($request->gallery)) {
                    RaffleImage::where('raffle_id', $raffle->id)->delete();
                    $raffleImages = [];
                    foreach ($request->gallery as $key => $item) {
                        $glr = explode(';base64,', $item['image']);

                        $name = (string) Str::uuid();
                        $webp = (string) Image::make(base64_decode($glr[1]))->fit(500, 500, function ($constraint) {
                            $constraint->upsize();
                        })->encode('webp', 95);
                        $path = config('filesystems.disks.s3.path') . '/images/' . $user_id . '/gallery/' . $raffle->id . '/' . $name . '.webp';

                        $image = Storage::disk(config('filesystems.default'))->put($path, $webp);

                        if ($image) {
                            $highlight = $key == 0 ? 1 : 0;
                            $raffleImages[] = [
                                'highlight' => $highlight,
                                'path' => $path,
                                'raffle_id' => $raffle->id
                            ];
                        }
                    }
                    if (!empty($raffleImages)) RaffleImage::insert($raffleImages);
                }

            DB::commit();

            return $this->index();
        } catch (QueryException $e) {
            DB::rollBack();
            setLogErros('SellerController->Update', $e->getMessage(), $request->all());
            return response()->json(['message' => 'Problema ao alterar a rifa, verifique os campos!'], 403);
        }
    }

    public function getParticipants(Request $request)
    {
        $request->validate([
            'query' => 'max:255',
            'page' => 'integer|string',
            'idRaffle' => 'required|integer|string'
        ]);

        $type = !empty($request->reserved) ? 'reserved' : 'paid';

        $query = $request->input('query');
        $query = htmlspecialchars($query, ENT_QUOTES, 'UTF-8');

        $page = $request->input('page', 1);
        $idRaffle = $request->input('idRaffle');
        // $perPage = 15;

        $user = auth()->user();
        $raffle = $user->raffles()->ofId($idRaffle)->first();

        // Busca no banco de dados com paginação
        $response = $query ? $raffle->participants()
            ->where($type, '>', 0)
            ->where(function ($subquery) use ($query) {
                $query = strtolower($query);
                $subquery->where(DB::raw('LOWER(name)'), 'LIKE', "%{$query}%")
                    ->orWhere(DB::raw('LOWER(email)'), 'LIKE', "%{$query}%")
                    ->orWhere(DB::raw('LOWER(document)'), 'LIKE', "%{$query}%")
                    ->orWhere(DB::raw('LOWER(phone)'), 'LIKE', "%{$query}%");
            })->paginate(15, ['*'], 'page', $page)
            :
            $raffle->participants()->orderBy('id')->where($type, '>', 0)->paginate(15, ['*'], 'page', $page);

        return response()->json($response);
    }

    public function edit($id)
    {
        $user = auth()->user();

        $raffle = Raffle::with([
            'raffle_premium_numbers' => function ($query) {
                $query->orderBy('raffle_premium_numbers.number_premium', 'ASC');
            }
        ])
            ->with([
                'raffle_images' => function ($query) {
                    $query->orderBy('raffle_images.highlight', 'DESC');
                }
            ])
            ->with([
                'raffle_awards' => function ($query) {
                    $query->orderBy('raffle_awards.order', 'ASC');
                }
            ])
            ->with([
                'raffle_popular_numbers' => function ($query) {
                    $query->orderBy('raffle_popular_numbers.quantity_numbers', 'ASC');
                }
            ])
            ->with([
                'raffle_promotions' => function ($query) {
                    $query->orderBy('raffle_promotions.order', 'ASC');
                }
            ])
            ->where('raffles.id', $id)
            ->Exclude(['numbers', 'video'])
            ->first();

        $data['quantity_numbers'] = [
            ['value' => 100, '100' => '100 cotas - (0 à 99)'],
            ['value' => 1000, '1.000' => '1.000 cotas - (0 à 999)'],
            ['value' => 10000, '10.000' => '10.000 cotas - (0 à 9.999)'],
            ['value' => 100000, '100.000' => '100.000 cotas - (0 à 99.999)'],
            ['value' => 1000000, '1.000.000' => '1.000.000 cotas - (0 à 999.999)'],
            ['value' => 10000000, '10.000.000' => '10.000.000 cotas - (0 à 9.999.999)']
        ];

        $galery = [];
        if(!empty($raffle->raffle_images)){
            foreach($raffle->raffle_images as $image){
                $s3TmpLink = new \stdClass();
                $s3TmpLink->img = Storage::disk(config('filesystems.default'))->temporaryUrl($image->path, now()->addMinutes(30));
                array_push($galery, $s3TmpLink);
            }
        }

        $promotions = [];
        if(!empty($raffle->raffle_promotions)){
            foreach($raffle->raffle_promotions as $promotion){
                $promo = new \stdClass();
                $promo->quantity_numbers = $promotion->quantity_numbers;
                $promo->discount = $promotion->discount;
                array_push($promotions, $promo);

                $raffle->promotions = $promotion;
            }
        }

        if ($raffle->highlight == 1 && !empty($raffle->banner)){
            $s3TmpLink = Storage::disk(config('filesystems.default'))->temporaryUrl($raffle->banner, now()->addMinutes(30));
            $raffle->new_banner = $s3TmpLink;
        }

        $data['raffle'] = $raffle;
        $data['raffle']['galery'] = $galery;
        $data['raffle']['promotions'] = $promotions;

        return Inertia::render('Seller/Raffle/RaffleCreate', $data);
    }

    public function reservedCanceled($participantId, $raffleId)
    {
        $user = auth()->user();

        $charge = Charge::leftJoin('charge_paids', 'charge_paids.charge_id', 'charges.id')
            ->join('participants', 'participants.id', 'charges.participant_id')
            ->join('raffles', 'raffles.id', 'participants.raffle_id')
            ->where('raffles.user_id', $user->id)
            ->where('participants.id', $participantId)
            ->where('participants.raffle_id', $raffleId)
            ->where('participants.paid', 0)
            ->where('charges.expired', '>', now())
            ->first([
                'charges.*',
                'charge_paids.id as pago'
            ]);

        if (empty($charge)) { //se tiver PIX gerado e dentro da expiracao nao deleta reserva
            $delete = numbers_devolution($raffleId, $participantId);
            if ($delete)
                return response()->json(true);
        }
        return response()->json(false);

        /*$raffle = $user->raffles()->find($raffleId);
        if($raffle) $participant = $raffle->participants()->find($participantId);
        else return response()->json(false);

        if($participant){
            $delete = numbers_devolution($raffleId, $participantId);
            if($delete) return response()->json(true);

            return response()->json(false);
        }else return response()->json(false);*/
    }

    public function live($id)
    {
        $user = auth()->user();

        $raffle = $user->raffles()->ofId($id)->first();

        $paid = Participant::where('raffle_id', $id)->where('paid', '>', 0)->groupBy('raffle_id')->get(DB::raw("string_agg(numbers, ',') as numbers"));
        $reserved = Participant::where('raffle_id', $id)->where('reserved', '>', 0)->groupBy('raffle_id')->get(DB::raw("string_agg(numbers, ',') as numbers"));

        /*$array_rifa = explode(',', $raffle->numbers);
        $array_reserva = explode(',', $reserved[0]['numbers']);
        $array_pagos = explode(',', $paid[0]['numbers']);

        $array_merge = array_merge($array_rifa, $array_pagos);
        $array_merge = array_merge($array_merge, $array_reserva);
        sort($array_merge);

        dd($array_merge);*/
        $data['reserved'] = !empty($reserved[0]['numbers']) ? $reserved[0]['numbers'] : null;
        $data['paid'] = !empty($paid[0]['numbers']) ? $paid[0]['numbers'] : null;
        $data['raffle'] = !empty($raffle->numbers) ? $raffle->numbers : null;

        return ['data' => $data];
    }

    public function export($id)
    {
        $user = auth()->user();

        $raffle = $user->raffles()->ofId($id)->first();

        $paid = $raffle->participants()->where('participants.raffle_id', $id)
            ->where('participants.paid', '>', 0)
            ->groupBy('participants.raffle_id', 'participants.id')
            ->get([DB::raw("string_agg(participants.numbers, ',') as numbers"), 'participants.name', 'participants.phone']);

        //$reserved = Participant::where('raffle_id', $id)->where('reserved', '>', 0)->groupBy('raffle_id')->get(DB::raw("string_agg(numbers, ',') as numbers"), 'id');

        if ($paid->isNotEmpty()) {
            $part = [];
            foreach ($paid as $item) {
                $array_numbers = explode(',', $item->numbers);
                foreach ($array_numbers as $number) {
                    $part[(int) $number] = [
                        'Numero' => $number,
                        'Nome' => $item->name,
                        'Telefone' => hideString($item->phone, 10, 3),
                        'Estado' => getDDDState($item->phone)
                    ];
                }
            }
            sort($part);

            $arqName = Str::slug($raffle->title) . '.csv';

            $writer = SimpleExcelWriter::streamDownload($arqName);

            $lazy = collect($part);

            $i = 0;
            foreach ($lazy->lazy() as $item) {
                $writer->addRow($item);

                if ($i % 1000 === 0) {
                    flush(); // Flush the buffer every 1000 rows
                }
                $i++;
            }
            $writer->toBrowser();
        }

        return back()->withInput();
    }

    public function awards($id)
    {
        $user = auth()->user();

        $raffle = $user->raffles()->ofId($id)->first();

        $awards = $raffle->raffle_awards()
            ->leftJoin('customers', 'customers.id', 'raffle_awards.customer_id')
            ->get(['raffle_awards.*', 'customers.name', 'customers.phone', 'customers.cpf']);
        //dd($awards);
        return Inertia::render('Seller/Raffle/View/RaffleAwards', ['awards' => $awards]);
    }

    public function award($raffleId, $number)
    {
        $user = auth()->user();

        $raffle = $user->raffles()->ofId($raffleId)->first();

        if($number >= $raffle->quantity) return response()->json(['msg' => 'Esse numero não pertence a rifa!']);

        $disponiveis = explode(",", $raffle->numbers); //pega os numeros disponiveis da rifa

        foreach ($disponiveis as $resultNumber) { //retira os numeros do array da rifa
            if($resultNumber === $number){
                return response()->json(['msg' => 'Esse numero não foi vendido!']);
            }
        }

        $participants = $raffle->participants()->where('participants.paid', '>', 0)->get();
        foreach ($participants as $participant){
            $numbersPart = explode(',', $participant->numbers);
            foreach ($numbersPart as $np){
                if($np === $number){
                    return response()->json($participant);
                }
            }
        }

        return response()->json(['msg' => 'Esse numero está reservado!']);
    }

    public function awardPart($raffleId, $awardId, $partId, $number)
    {
        $user = auth()->user();

        DB::beginTransaction(); //inicia a transaction no banco
        try {
            $raffle = $user->raffles()->ofId($raffleId)->first();
            $participant = $raffle->participants()->where('participants.id', $partId)->first();

            $up = $raffle->raffle_awards()->where('raffle_awards.id', $awardId)->first();

            $up->winner_name = $participant->name;
            $up->winner_phone = $participant->phone;
            $up->number_award = $number;
            $up->customer_id = $participant->customer_id;
            $up->save();

            DB::commit();
            return response()->json(true);
        }catch (QueryException $e){
            DB::rollBack();
            setLogErros('Awards->save', $e->getMessage(), [$raffleId, $awardId, $partId, $number], 'catch', $raffleId);
            return response()->json(false);
        }
    }
}
