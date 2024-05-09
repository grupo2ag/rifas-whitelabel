<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RaffleImage
 * 
 * @property int $id
 * @property string|null $path
 * @property int $raffle_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $highlight
 * 
 * @property Raffle $raffle
 *
 * @package App\Models
 */
class RaffleImage extends Model
{
	protected $table = 'raffle_images';

	protected $casts = [
		'raffle_id' => 'int',
		'highlight' => 'int'
	];

	protected $fillable = [
		'path',
		'raffle_id',
		'highlight'
	];

	public function raffle()
	{
		return $this->belongsTo(Raffle::class);
	}
}
