<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RafflePopularNumber
 * 
 * @property int $id
 * @property int $quantity_numbers
 * @property bool $popular
 * @property int $raffle_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Raffle $raffle
 *
 * @package App\Models
 */
class RafflePopularNumber extends Model
{
	protected $table = 'raffle_popular_numbers';

	protected $casts = [
		'quantity_numbers' => 'int',
		'popular' => 'bool',
		'raffle_id' => 'int'
	];

	protected $fillable = [
		'quantity_numbers',
		'popular',
		'raffle_id'
	];

	public function raffle()
	{
		return $this->belongsTo(Raffle::class);
	}
}
