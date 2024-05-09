<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Devolution
 *
 * @property int $id
 * @property string $payload_pix
 * @property string $numbers
 * @property int $amount
 * @property int $quantity
 * @property int $participant_id
 * @property int $charge_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Participant $participant
 * @property Charge $charge
 *
 * @package App\Models
 */
class Devolution extends Model
{
	protected $table = 'devolutions';

    public $timestamps = true;

	protected $casts = [
		'amount' => 'int',
		'quantity' => 'int',
		'participant_id' => 'int',
		'charge_id' => 'int'
	];

	protected $fillable = [
		'payload_pix',
		'numbers',
		'amount',
		'quantity',
		'participant_id',
		'charge_id'
	];

	public function participant()
	{
		return $this->belongsTo(Participant::class);
	}

	public function charge()
	{
		return $this->belongsTo(Charge::class);
	}
}
