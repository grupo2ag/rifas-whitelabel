<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Affiliate;
use App\Models\AffiliateRaffle;
use App\Models\Charge;
use App\Models\Customer;
use App\Models\Participant;
use App\Models\Raffle;
use App\Models\RaffleImage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Ramsey\Uuid\Uuid;
use function Laravel\Prompts\select;

class RaffleController extends Controller
{
    private $user_id;

    public function __construct()
    {
        $this->user_id = (!empty(inertia()->getShared('siteconfig')->user_id)) ? inertia()->getShared('siteconfig')->user_id : false;

        if(!$this->user_id) return Inertia::render('Welcome');//return redirect('/');
    }

    public function index(string $url, string $affiliate = null)
    {

        $toview = explode('-', $url);
        $contains = Str::containsAll('visualizar|raffle', [$toview[0]]);
        $visible = 1;
        if($contains){
            unset($toview[0]);
            $url = implode('-', $toview);
            $visible = 0;
        }

        $affiliateId = null;
        if(!empty($affiliate)){
            $hasAffiliate = AffiliateRaffle::with('affiliate')->whereHas('affiliate', function ($query) {
                return $query->where('user_id', $this->user_id);
            })
                ->where('link', $affiliate)
                ->first();
            if(!empty($hasAffiliate->affiliate->id)) $affiliateId = $hasAffiliate->affiliate->id;
        }

        $raffle = Raffle::with(['raffle_premium_numbers' => function ($query) {
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
                        //->ActivateRaffles()
                        ->Visible($visible)
                        ->first([
                            DB::raw("CASE WHEN raffles.type = '".Raffle::TYPE_MANUAL."' THEN raffles.numbers ELSE '' END AS r_numbers"),
                            'id',
                            'title',
                            'subtitle',
                            'pix_expired',
                            'price',
                            'quantity',
                            'type',
                            'link',
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

        if(!empty($raffle)){
            $participant = Participant::where('raffle_id', $raffle->id)->sum('paid');

            $totalSales = $participant*100/$raffle->quantity;
            $totalSales = ($participant > 0) ? ceil($totalSales) : 0.00;

            $raffle['percent'] = $totalSales;
            $galery = [];
            if(!empty($raffle->raffle_images)){
                foreach($raffle->raffle_images as $image){
                    //$mountUrl = config('filesystems.disks.s3.path').'/images/'.$this->user_id.'/gallery/'.$raffle->id.'/'.$image->path;

                    $s3TmpLink = new \stdClass();
                    $s3TmpLink->img = Storage::disk(config('filesystems.default'))->temporaryUrl($image->path, now()->addMinutes(30));
                    array_push($galery, $s3TmpLink);
                }
            }

            $raffle['galery'] = $galery;

            if($raffle->buyer_ranking > 0 ) {
                $raffle['buyers'] = Participant::orderBy('total', 'DESC')
                    ->join('customers', 'customers.id', '=', 'participants.customer_id')
                    ->select(DB::raw("SUM(paid) AS total"), 'customers.name')
                    ->where('participants.raffle_id', $raffle->id)
                    ->limit($raffle->buyer_ranking)
                    ->groupBy('participants.customer_id', 'customers.id')
                    ->get();
                }
            else $raffle['buyers'] = [];

            $raffle['participants'] = [];
            if($raffle->type === 'manual'){
                $raffle['participants'] = Participant::join('customers', 'customers.id', '=', 'participants.customer_id')
                    ->select('participants.*')
                    ->where('participants.raffle_id', $raffle->id)
                    /*->where(function ($query){
                        $query->where('participants.reserved', '>', '0')
                              ->whereOr('participants.paid', '>', '0');
                    })*/
                    ->orderBy('participants.numbers', 'DESC')
                    ->get();
            }

            $raffle['affiliate_id'] = $affiliateId;

            $return['meta'] = [
                'title'       => $raffle->title . ' | ' . inertia()->getShared('siteconfig')->site_title,
                'description' => $raffle->subtitle,
                'image'       => $galery[0]->img,
            ];

            return Inertia::render('Site/Raffle/Raffle', ['raffle' => $raffle])->withViewData('meta', $return['meta']);
        }

        return redirect('/');
    }

    public function verify($cpf)
    {
       // $phone = '55 '.$phone;

        //$data = Customer::where('phone', $phone)->first();
        $data = Customer::where('cpf', $cpf)->first();

        $return = [];
        if(!empty($data->id)){
            //$phone = str_replace('55 ', '', $phone);
            $return = [
                'buyer' => $data->id,
                'name' => $data->name,
                'cpf' => !empty($data->cpf) ? hideString($data->cpf, 3,3) : '',
                'phone' => !empty($data->phone) ? hideString($data->phone, 8, 3) : '',
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
                'email' => $email,
                'cpf' => Str::trim($request->cpf),
                'affiliate_id' => !empty($request->affiliate_id) ? $request->affiliate_id : null
            ];
        }else{
            $return = Customer::find($request->buyer);
            $registration_data = [
                'name' => $return->name,
                'phone' => $return->phone,
                'email' => $return->email,
                'cpf' => $return->cpf,
                'affiliate_id' => !empty($request->affiliate_id) ? $request->affiliate_id : null
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

            if(!empty($request->raffle_type) && $request->raffle_type === 'manual'){
                $pix = numbers_reserve($request->raffle_id, $request->quantity, $return->id, $registration_data, false, $request->manual);
            }else $pix = numbers_reserve($request->raffle_id, $request->quantity, $return->id, $registration_data, false);

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
                    'raffles.type',
                    'raffles.pix_expired',
                    'charge_paids.id as pago',
                    'participants.paid'
                ]);
            //dd($rifa);
            if(!empty($rifa->id)){
                $image = RaffleImage::where('raffle_id', $rifa->raffle_id)->where('highlight', 1)->first();
                if(!empty($image)){
                    //$mountUrl = config('filesystems.disks.s3.path').'/images/'.$rifa->raffle_id.'/'.$image->path;
                    $mountUrl =$image->path;
                    $rifa['image'] = Storage::disk(config('filesystems.default'))->temporaryUrl($mountUrl, now()->addMinutes(30));
                }

                $status = 'PROCESSING';
                if($rifa->pago) $status = 'PAID';
                //else $status = 'CANCELED';

                $return['meta'] = [
                    'title'       => 'Detalhe do Pagamento',
                ];

                return Inertia::render('Site/Payment/PaymentIndex', ['raffle' => $rifa, 'status' => $status])->withViewData('meta', $return['meta']);
            }
        } else {
            return back();
        }
    }

    public function reserved($participant)
    {
        if($participant){

            $rifa = Participant::join('raffles', 'raffles.id', 'participants.raffle_id')
                ->where('participants.id', $participant)
                //->where('participants.paid', 0)
                ->first([
                    'participants.id',
                    'participants.name',
                    'participants.phone',
                    'participants.email',
                    'participants.document',
                    'participants.numbers',
                    'participants.reserved',
                    'participants.paid',
                    'participants.raffle_id',
                    'participants.numbers',
                    'participants.amount',
                    'participants.expired_at',
                    'raffles.price',
                    'raffles.title',
                    'raffles.subtitle',
                    'raffles.pix_expired'
                ]);

            $return['meta'] = [
                'title'       => 'Detalhe do Pagamento',
            ];

            if(!empty($rifa->raffle_id) && !empty($rifa->reserved)){
                $image = RaffleImage::where('raffle_id', $rifa->raffle_id)->where('highlight', 1)->first();

                if(!empty($image)){
                    //$mountUrl = config('filesystems.disks.s3.path').'/images/'.$rifa->raffle_id.'/'.$image->path;
                    $mountUrl = $image->path;
                    $rifa['image'] = Storage::disk(config('filesystems.default'))->temporaryUrl($mountUrl, now()->addMinutes(30));
                }
                //dd($rifa);
                $status = 'PROCESSING';
                if ($rifa->reserved) $status = 'RESERVED';
                //else $status = 'CANCELED';

                $rifa['expired'] = Carbon::parse($rifa->expired_at)->subMinutes(Raffle::TOLERANCIA_PAGAMENTO);

                //dd(['raffle' => $rifa, 'status' => $status]);

                return Inertia::render('Site/Payment/PaymentIndex', ['raffle' => $rifa, 'status' => $status])->withViewData('meta', $return['meta']);
            }else{
                $status = 'PROCESSING';
                if($rifa->paid) $status = 'PAID';
                //dd(['raffle' => $rifa, 'status' => $status]);
                return Inertia::render('Site/Payment/PaymentIndex', ['raffle' => $rifa, 'status' => $status])->withViewData('meta', $return['meta']);
            }
        } else {
            return redirect('/');
        }
    }

    public function reservedVerify($id)
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
            ->where('raffles.id', $id)
            ->UserID($this->user_id)
            ->ActivateRaffles()
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
                'link',
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
                    //$mountUrl = config('filesystems.disks.s3.path').'/images/'.$this->user_id.'/gallery/'.$rifa->id.'/'.$image->path;

                    $s3TmpLink = new \stdClass();
                    $s3TmpLink->img = Storage::disk(config('filesystems.default'))->temporaryUrl($image->path, now()->addMinutes(30));
                    array_push($galery, $s3TmpLink);
                }
            }

            $rifa['galery'] = $galery;

            if($rifa->buyer_ranking > 0 ) {
                $rifa['buyers'] = Participant::orderBy('total', 'DESC')
                    ->join('customers', 'customers.id', '=', 'participants.customer_id')
                    ->select(DB::raw("SUM(paid) AS total"), 'customers.name')
                    ->where('participants.raffle_id', $rifa->id)
                    ->limit($rifa->buyer_ranking)
                    ->groupBy('participants.customer_id', 'customers.id')
                    ->get();
            }
            else $rifa['buyers'] = [];

            $rifa['participants'] = [];
            if($rifa->type === 'manual'){
                $rifa['participants'] = Participant::join('customers', 'customers.id', '=', 'participants.customer_id')
                    ->select('participants.*')
                    ->where('participants.raffle_id', $rifa->id)
                    /*->where(function ($query){
                        $query->where('participants.reserved', '>', '0')
                            ->whereOr('participants.paid', '>', '0');
                    })*/
                    ->orderBy('participants.numbers', 'DESC')
                    ->get();
            }

            return response()->json(['raffle' => $rifa], 200);
        }
        return response()->json(false, 403);
    }

    public function generate($participantID)
    {
        $rifa = Charge::leftJoin('charge_paids', 'charge_paids.charge_id', 'charges.id')
            ->join('participants', 'participants.id', 'charges.participant_id')
            ->join('raffles', 'raffles.id', 'participants.raffle_id')
            ->where('participants.id', $participantID)
            ->where('participants.paid', 0)
            ->where('charges.expired', '>', now())
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

        if($rifa){
            return response()->json(['raffle' => $rifa]);
        }

        $participant = Participant::join('raffles', 'raffles.id', 'participants.raffle_id')
                                  ->where('participants.id', $participantID)
                                  ->where('participants.paid', 0)
                                  ->first(['participants.name',
                                          'participants.id',
                                          'participants.phone',
                                          'participants.email',
                                          'participants.document',
                                          'participants.amount',
                                          'participants.numbers',
                                          'participants.reserved',
                                          'participants.raffle_id',
                                          'participants.numbers',
                                          'raffles.price',
                                          'raffles.title',
                                          'raffles.subtitle',
                                          'raffles.pix_expired']);

        if($participant){

            $minutes = !empty($participant->pix_expired) ? $participant->pix_expired : 5;
            $expired = Carbon::now()->addMinutes($minutes);

            $expired_time = (int)$minutes*60;

            $pix_data = [
                "value" => $participant->amount,
                "payer_name" => $participant->name,
                "payer_doc" => !empty($participant->document) ?$participant->document : null,
                "expiration_time" => $expired_time > 86400 ? 86400 : $expired_time,
                "description" => $participant->title.'-'.$participant->raffle_id,
                "order_id" => UUID::uuid4(),
                "participant" => $participant->id
            ];

            $generator = pixcred_generate($participant->raffle_id, $pix_data);

            $charge = Charge::create([
                'pix_id' => $generator['order_id'],
                'pix_code' => $generator['pix_link'],
                'amount' => $pix_data['value'],
                'json' => json_encode($generator),
                'expired' => $expired,
                'participant_id' => $participant->id
            ]);

            $participant['pago'] = null;
            $participant['pix_id'] = $charge->pix_id;
            $participant['pix_code'] = $charge->pix_code;
            $participant['json'] = $charge->json;
            $participant['expired'] = $charge->expired;
            //dd($participant);
            return response()->json(['raffle' => $participant]);
        }else return redirect('/');
    }

    public function mybillets($cpf){

        if(!empty($cpf)){
            $participant = Participant::with(['raffle' => function ($query) {
                    $query->select(['title', 'status', 'type']);
                }])
                ->with(['raffle.raffle_images' => function ($query) {
                        //$query->orderBy('raffle_images.highlight', 'DESC');
                        $query->whereRaw('raffle_images.id IN (SELECT MAX(a2.id) FROM raffle_images AS a2 WHERE a2.id = raffle_images.id AND highlight = 1)');
                }])
                ->whereHas('raffle', function ($query) {
                    return $query->UserID($this->user_id)
                        ->Visible(true)
                        ->ActivateRaffles('Ativo');
                })
                ->where('document', $cpf)
                ->orderBy('participants.id', 'DESC')
                ->get();

            if(!empty($participant)){
            //if(!empty($participant->items())){
                //foreach ($participant->items() as $key => $item) {
                foreach ($participant as $key => $item) {
                    //$galery = [];
                    //dd($item, $item->raffle, $item->raffle->raffle_images);
                    if(!empty($item->raffle->raffle_images)){
                        foreach($item->raffle->raffle_images as $image){
                            //$mountUrl = config('filesystems.disks.s3.path').'/images/'.$this->user_id.'/gallery/'.$rifa->id.'/'.$image->path;

                            //$s3TmpLink = new \stdClass();
                            $participant[$key]['galery'] = Storage::disk(config('filesystems.default'))->temporaryUrl($image->path, now()->addMinutes(30));
                            //array_push($galery, $s3TmpLink);
                        }
                    }else $participant[$key]['galery'] = null;

                    $participant[$key]['count'] = count((explode(',', $participant[$key]['numbers'])));

                    //dd($participant[$key]['raffle']['type']);
                    if(Carbon::now() > $participant[$key]['expired_at'] && $participant[$key]['raffle']['type'] === 'automatico'){
                        //dd($participant[$key]);

                        if($participant[$key]['reserved'] > 0) $status = 'CANCELED';
                        else if($participant[$key]['paid'] > 0) $status = 'PAID';
                    }else{
                        if($participant[$key]['reserved'] > 0) $status = ($participant[$key]['raffle']['type'] === 'automatico') ? 'PROCESSING' : 'RESERVED';
                        else if($participant[$key]['paid'] > 0) $status = 'PAID';
                    }

                    $participant[$key]['purchase'] = $status;
                }
            }
            //dd($participant);
            return Inertia::render('Site/Account/Account', ['participant' => $participant]);
        }

        return Inertia::render('Site/Account/Account');
    }

    public function openPay($participantID){
        $rifa = Charge::leftJoin('charge_paids', 'charge_paids.charge_id', 'charges.id')
            ->join('participants', 'participants.id', 'charges.participant_id')
            ->join('raffles', 'raffles.id', 'participants.raffle_id')
            ->where('participants.id', $participantID)
            ->where('participants.paid', 0)
            ->where('charges.expired', '>', now())
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
                'participants.id as pid',
                'raffles.price',
                'raffles.title',
                'raffles.subtitle',
                'raffles.pix_expired',
                'charge_paids.id as pago'
            ]);

        if($rifa){
            return redirect('pay/'.$rifa->pix_id);
        }else{
            return redirect('reserved/'.$participantID);
        }
    }
}
