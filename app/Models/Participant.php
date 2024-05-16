<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
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
 * @property int $raffle_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property Carbon|null $expired_at
 * @property int|null $customer_id
 * 
 * @property Raffle $raffle
 * @property Customer|null $customer
 * @property Collection|AffiliateGain[] $affiliate_gains
 * @property Collection|Charge[] $charges
 * @property Collection|Devolution[] $devolutions
 *
 * @package App\Models
 */
class Participant extends Model
{
	use SoftDeletes;
	protected $table = 'participants';

	protected $casts = [
		'checked' => 'int',
		'msg_paid_sent' => 'int',
		'amount' => 'int',
		'paid' => 'int',
		'reserved' => 'int',
		'raffle_id' => 'int',
		'expired_at' => 'datetime',
		'customer_id' => 'int'
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
		'raffle_id',
		'expired_at',
		'customer_id'
	];

	public function raffle()
	{
		return $this->belongsTo(Raffle::class);
	}

	public function customer()
	{
		return $this->belongsTo(Customer::class);
	}

	public function affiliate_gains()
	{
		return $this->hasMany(AffiliateGain::class);
	}

    public function scopeOfRaffleId($query, $id)
    {
        return $query->where('raffle_id', $id);
    }

	public function charges()
	{
		return $this->hasMany(Charge::class);
	}

	public function devolutions()
	{
		return $this->hasMany(Devolution::class);
	}
}
