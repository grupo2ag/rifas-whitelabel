<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Participant
 *
 * @property int $id
 * @property int $checked
 * @property int|null $msg_paid_sent
 * @property string $name
 * @property string $phone
 * @property string|null $email
 * @property string|null $document
 * @property int $amount
 * @property string $numbers
 * @property int|null $paid
 * @property int|null $reserved
 * @property int|null $customer_id
 * @property int $raffle_id
 *
 * @property Raffle $raffle
 * @property Collection|AffiliateGain[] $affiliate_gains
 * @property Collection|Charge[] $charges
 *
 * @package App\Models
 */
class Participant extends Model
{
    use HasFactory, SoftDeletes;

	protected $table = 'participants';
	public $timestamps = true;

	protected $casts = [
		'checked' => 'int',
		'msg_paid_sent' => 'int',
		'amount' => 'int',
		'paid' => 'int',
		'reserved' => 'int',
		'customer_id' => 'int',
		'raffle_id' => 'int',
		'rafflepromotion_id' => 'int'
	];

	protected $fillable = [
		'checked',
		'msg_paid_sent',
		'name',
		'phone',
		'email',
		'document',
		'amount',
		'numbers',
		'paid',
		'reserved',
		'customer_id',
		'raffle_id',
        'rafflepromotion_id',
        'expired_at'
	];

	public function raffle()
	{
		return $this->belongsTo(Raffle::class);
	}

	public function affiliate_gains()
	{
		return $this->hasMany(AffiliateGain::class);
	}

	public function charges()
	{
		return $this->hasMany(Charge::class);
	}
}
