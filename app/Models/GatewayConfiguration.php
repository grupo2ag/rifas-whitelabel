<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class GatewayConfiguration
 *
 * @property int $id
 * @property string|null $token
 * @property string|null $login
 * @property int $gateway_id
 * @property int $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Gateway $gateway
 * @property User $user
 *
 * @package App\Models
 */
class GatewayConfiguration extends Model
{
	protected $table = 'gateway_configurations';

	protected $casts = [
		'gateway_id' => 'int',
		'user_id' => 'int'
	];

	protected $hidden = [
		//'token'
	];

	protected $fillable = [
		'token',
		'login',
		'gateway_id',
		'user_id'
	];

	public function gateway()
	{
		return $this->belongsTo(Gateway::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
