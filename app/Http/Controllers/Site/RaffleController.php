<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Charge;
use App\Models\Customer;
use App\Models\Participant;
use App\Models\Raffle;
use App\Models\RaffleImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Inertia\Inertia;
use function Laravel\Prompts\select;

class RaffleController extends Controller
{
    private $user_id;

    public function __construct()
    {
        $this->user_id = (!empty(inertia()->getShared('siteconfig')->user_id)) ? inertia()->getShared('siteconfig')->user_id : false;

        if(!$this->user_id) return Inertia::render('Welcome');//return redirect('/');
    }

    public function index($url)
    {
        $rifa = Raffle::with(['raffle_premium_numbers' => function ($query) {
                            $query->orderBy('raffle_premium_numbers.number_premium', 'ASC');
                        }])
                        ->with(['raffle_images' => function ($query) {
                            $query->orderBy('raffle_images.highlight', 'DESC');
                        }])
                        ->with(['raffle_awards' => function ($query) {
                            $query->orderBy('raffle_awards.order', 'ASC');
                        }])
                        ->with(['raffle_popular_numbers' => function ($query) {
                            $query->orderBy('raffle_popular_numbers.quantity_numbers', 'ASC');
                        }])
                        ->with(['raffle_promotions' => function ($query) {
                            $query->orderBy('raffle_promotions.order', 'ASC');
                        }])
                        ->Slug($url)
                        ->UserID($this->user_id)
                        ->Visible(true)
                        ->first([
                            DB::raw("CASE WHEN raffles.type = '".Raffle::TYPE_MANUAL."' THEN raffles.numbers ELSE '' END AS r_numbers"),
                            'id',
                            'title',
                            'subtitle',
                            'pix_expired',
                            'price',
                            'quantity',
                            'type',
                            'status',
                            'highlight',
                            'highlight_order',
                            'minimum_purchase',
                            'maximum_purchase',
                            'visible',
                            'user_id',
                            'partial',
                            'description',
                            'gateway_id',
                            'total',
                            'banner',
                            'expected_date',
                            'buyer_ranking'
                        ]);

        if(!empty($rifa)){
            $participant = Participant::where('raffle_id', $rifa->id)->sum('paid');

            $totalSales = $participant*100/$rifa->quantity;
            $totalSales = ($participant > 0) ? ceil($totalSales) : 0.00;

            $rifa['percent'] = $totalSales;
            $galery = [];
            if(!empty($rifa->raffle_images)){
                foreach($rifa->raffle_images as $image){
                    $mountUrl = config('filesystems.disks.s3.path').'/images/'.$rifa->id.'/'.$image->path;

                    $s3TmpLink = new \stdClass();
                    $s3TmpLink->img = Storage::disk(config('filesystems.default'))->temporaryUrl($mountUrl, now()->addMinutes(30));
                    array_push($galery, $s3TmpLink);
                }
            }

            $rifa['galery'] = $galery;

            if($rifa->buyer_ranking > 0 ) {
                $rifa['buyers'] = Participant::orderBy('total', 'DESC')
                    ->join('customers', 'customers.id', '=', 'participants.customer_id')
                    ->select(DB::raw("SUM(paid) AS total"), 'customers.name')
                    ->limit($rifa->buyer_ranking)
                    ->groupBy('participants.customer_id', 'customers.id')
                    ->get();
                }
            else $rifa['buyers'] = [];

            //dd($rifa);

            return Inertia::render('Site/Raffle/Raffle', ['raffle' => $rifa]);
        }

        return redirect('/');
    }

    public function verify($phone)
    {
        $phone = '55 '.$phone;

        $data = Customer::where('phone', $phone)->first();

        $return = [];
        if(!empty($data->id)){
            $phone = str_replace('55 ', '', $phone);
            $return = [
                'buyer' => $data->id,
                'name' => $data->name,
                'cpf' => !empty($data->cpf) ? hideString($data->cpf, 3,3) : '',
                'phone' => !empty($phone) ? hideString($phone, 8, 3) : '',
                'email' => !empty($data->email) ? hideString($data->email, 3,3) : '',
            ];
        }

        return response()->json($return, 200);
    }

    public function purchase(Request $request)
    {

        if(empty($request->buyer)){
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'phone' => 'required|string|max:15',
                'email' => 'required|string|email|max:255',
                'cpf' => 'required|string|max:14'
            ]);
            if ($validator->fails()) {
                return response()->json(['message' => $validator->messages()], 403);
            }

            $name = Str::trim($request->name);
            $phone = '55 '.Str::trim($request->phone);
            $email= Str::trim($request->email);

            $return = Customer::updateOrCreate(
                [
                    'cpf'   => Str::trim($request->cpf)
                ],
                [
                    'name'  => $name,
                    'phone' => $phone,
                    'email' => Str::trim(Str::lower($request->email))
                ]
            );

            $registration_data = [
                'name' => $name,
                'phone' => $phone,
                'email' => $email
            ];
        }else{
            $return = Customer::find($request->buyer);
            $registration_data = [
                'name' => $return->name,
                'phone' => $return->phone,
                'email' => $return->email
            ];
        }

        $validator = Validator::make($request->all(), [
            'quantity' => 'required|numeric|min:1',
            'total' => 'required|numeric|min:100',
            'raffle_id' => 'required',
            'user_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->messages()], 403);
        }

        $return['raffle_id'] = $request->raffle_id;
        $return['user_id'] = $request->user_id;

        if(!empty($return->id)){
            $pix = numbers_reserve($request->raffle_id, $request->quantity, $return->id, $registration_data, false);

            if(!$pix['errors']){
                unset($pix['numbers']);
                //dd($pix);
                return response()->json($pix, 200);
            }else{
                return response()->json($pix, 403);
            }
        }

        return response()->json($return, 403);
    }

    public function pay($order)
    {
        if($order){
            $rifa = Charge::leftJoin('charge_paids', 'charge_paids.charge_id', 'charges.id')
                ->join('participants', 'participants.id', 'charges.participant_id')
                ->join('raffles', 'raffles.id', 'participants.raffle_id')
                ->where('charges.pix_id', $order)
                //->where('participants.paid', 0)
                //->whereNull('charge_paids.id')
                ->first([
                    'charges.*',
                    'participants.name',
                    'participants.phone',
                    'participants.email',
                    'participants.document',
                    'participants.numbers',
                    'participants.reserved',
                    'participants.raffle_id',
                    'participants.numbers',
                    'raffles.price',
                    'raffles.title',
                    'raffles.subtitle',
                    'raffles.pix_expired',
                    'charge_paids.id as pago'
                ]);
            //dd($rifa);
            if(!empty($rifa->id)){
                $image = RaffleImage::where('raffle_id', $rifa->raffle_id)->where('highlight', 1)->first();
                if(!empty($image)){
                    $mountUrl = config('filesystems.disks.s3.path').'/images/'.$rifa->raffle_id.'/'.$image->path;
                    $rifa['image'] = Storage::disk(config('filesystems.default'))->temporaryUrl($mountUrl, now()->addMinutes(30));
                }

                $status = 'PROCESSING';
                if($rifa->pago) $status = 'PAID';
                //else $status = 'CANCELED';

                return Inertia::render('Site/Payment/PaymentIndex', ['raffle' => $rifa, 'status' => $status]);
            }
        } else {
            return back();
        }
    }

}
