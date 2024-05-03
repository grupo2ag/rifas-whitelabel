<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ChargePaid
 *
 * @property int $id
 * @property string $e2e
 * @property Carbon $paied_date
 * @property int $charge_id
 * @property string|null $json_response
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Charge $charge
 *
 * @package App\Models
 */
class ChargePaid extends Model
{
    use HasFactory;

	protected $table = 'charge_paids';

    public $timestamps = true;

	protected $casts = [
		'paied_date' => 'datetime',
		'charge_id' => 'int'
	];

	protected $fillable = [
		'e2e',
		'paied_date',
		'charge_id',
		'json_response'
	];

	public function charge()
	{
		return $this->belongsTo(Charge::class);
	}
}
