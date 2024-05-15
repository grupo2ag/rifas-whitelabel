<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RaffleImage
 *
 * @property int $id
 * @property string|null $path
 * @property int $raffle_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Raffle $raffle
 *
 * @package App\Models
 */
class RaffleImage extends Model
{
    use HasFactory;

	protected $table = 'raffle_images';

    public $timestamps = true;

	protected $casts = [
		'raffle_id' => 'int'
	];

	protected $fillable = [
		'path',
		'raffle_id'
	];

	public function raffle()
	{
		return $this->belongsTo(Raffle::class);
	}
    public function scopeOfRaffleId($query, $id)
    {
        return $query->where('raffle_id', $id);
    }
}
