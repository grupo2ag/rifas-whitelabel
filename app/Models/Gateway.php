<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Gateway
 * 
 * @property int $id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $endpoint_sandbox
 * @property string|null $auth_sandbox
 * @property string|null $endpoint_prod
 * @property string|null $auth_prod
 * 
 * @property Collection|Raffle[] $raffles
 * @property Collection|GatewayConfiguration[] $gateway_configurations
 *
 * @package App\Models
 */
class Gateway extends Model
{
	protected $table = 'gateways';

	protected $fillable = [
		'name',
		'endpoint_sandbox',
		'auth_sandbox',
		'endpoint_prod',
		'auth_prod'
	];

	public function raffles()
	{
		return $this->hasMany(Raffle::class);
	}

	public function gateway_configurations()
	{
		return $this->hasMany(GatewayConfiguration::class);
	}
}
