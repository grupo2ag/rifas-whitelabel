<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RaffleAward
 *
 * @property int $id
 * @property int|null $ordem
 * @property string $descricao
 * @property string|null $winner_name
 * @property string|null $winner_image
 * @property string|null $winner_phone
 * @property int|null $number_award
 * @property int $raffle_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Raffle $raffle
 *
 * @package App\Models
 */
class RaffleAward extends Model
{
    use HasFactory;

	protected $table = 'raffle_awards';

    public $timestamps = true;

	protected $casts = [
		'order' => 'int',
		'number_award' => 'int',
		'raffle_id' => 'int'
	];

	protected $fillable = [
		'order',
		'description',
		'winner_name',
		'winner_image',
		'winner_phone',
		'number_award',
		'raffle_id'
	];

	public function raffle()
	{
		return $this->belongsTo(Raffle::class);
	}
}
