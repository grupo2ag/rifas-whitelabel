<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Charge
 * 
 * @property int $id
 * @property string $pix_id
 * @property string $pix_code
 * @property int $amount
 * @property string $json
 * @property Carbon|null $expired
 * @property int $participant_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Participant $participant
 * @property Collection|ChargePaid[] $charge_paids
 *
 * @package App\Models
 */
class Charge extends Model
{
	protected $table = 'charges';

	protected $casts = [
		'amount' => 'int',
		'expired' => 'datetime',
		'participant_id' => 'int'
	];

	protected $fillable = [
		'pix_id',
		'pix_code',
		'amount',
		'json',
		'expired',
		'participant_id'
	];

	public function participant()
	{
		return $this->belongsTo(Participant::class);
	}

	public function charge_paids()
	{
		return $this->hasMany(ChargePaid::class);
	}
}
