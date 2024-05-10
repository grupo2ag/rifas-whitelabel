<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RafflePremiumNumber
 * 
 * @property int $id
 * @property string $description
 * @property string|null $winner_name
 * @property string|null $winner_image
 * @property string|null $winner_phone
 * @property int|null $number_premium
 * @property int $raffle_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Raffle $raffle
 *
 * @package App\Models
 */
class RafflePremiumNumber extends Model
{
	protected $table = 'raffle_premium_numbers';

	protected $casts = [
		'number_premium' => 'int',
		'raffle_id' => 'int'
	];

	protected $fillable = [
		'description',
		'winner_name',
		'winner_image',
		'winner_phone',
		'number_premium',
		'raffle_id'
	];

	public function raffle()
	{
		return $this->belongsTo(Raffle::class);
	}
}
