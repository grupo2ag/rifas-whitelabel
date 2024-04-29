<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AffiliateGain
 * 
 * @property int $id
 * @property int|null $amount
 * @property int $participant_id
 * @property int $raffle_id
 * @property int $affiliate_id
 * @property int $paied
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Participant $participant
 * @property AffiliateRaffle $affiliate_raffle
 *
 * @package App\Models
 */
class AffiliateGain extends Model
{
	protected $table = 'affiliate_gains';

	protected $casts = [
		'amount' => 'int',
		'participant_id' => 'int',
		'raffle_id' => 'int',
		'affiliate_id' => 'int',
		'paied' => 'int'
	];

	protected $fillable = [
		'amount',
		'participant_id',
		'raffle_id',
		'affiliate_id',
		'paied'
	];

	public function participant()
	{
		return $this->belongsTo(Participant::class);
	}

	public function affiliate_raffle()
	{
		return $this->belongsTo(AffiliateRaffle::class, 'raffle_id')
					->where('affiliate_raffles.affiliate_id', '=', 'affiliate_gains.raffle_id')
					->where('affiliate_raffles.raffle_id', '=', 'affiliate_gains.raffle_id')
					->where('affiliate_raffles.affiliate_id', '=', 'affiliate_gains.affiliate_id')
					->where('affiliate_raffles.raffle_id', '=', 'affiliate_gains.affiliate_id');
	}
}
