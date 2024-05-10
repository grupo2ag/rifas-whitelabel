<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RafflePromotion
 * 
 * @property int $id
 * @property int $quantity_numbers
 * @property int $order
 * @property int $discount
 * @property int $amount
 * @property int $raffle_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property bool $is_popular
 * 
 * @property Raffle $raffle
 * @property Collection|Raffle[] $raffles
 *
 * @package App\Models
 */
class RafflePromotion extends Model
{
	protected $table = 'raffle_promotions';

	protected $casts = [
		'quantity_numbers' => 'int',
		'order' => 'int',
		'discount' => 'int',
		'amount' => 'int',
		'raffle_id' => 'int',
		'is_popular' => 'bool'
	];

	protected $fillable = [
		'quantity_numbers',
		'order',
		'discount',
		'amount',
		'raffle_id',
		'is_popular'
	];

	public function raffle()
	{
		return $this->belongsTo(Raffle::class);
	}

	public function raffles()
	{
		return $this->hasMany(Raffle::class);
	}
}
