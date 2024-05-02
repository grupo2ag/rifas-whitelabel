<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RafflePromotion
 *
 * @property int $id
 * @property int $quantity_numbers
 * @property int $ordem
 * @property int $discount
 * @property int $amount
 * @property int $raffle_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Raffle $raffle
 *
 * @package App\Models
 */
class RafflePromotion extends Model
{
    use HasFactory;

	protected $table = 'raffle_promotions';

	protected $casts = [
		'quantity_numbers' => 'int',
		'ordem' => 'int',
		'discount' => 'int',
		'amount' => 'int',
		'raffle_id' => 'int'
	];

	protected $fillable = [
		'quantity_numbers',
		'ordem',
		'discount',
		'amount',
		'raffle_id'
	];

	public function raffle()
	{
		return $this->belongsTo(Raffle::class);
	}
}
