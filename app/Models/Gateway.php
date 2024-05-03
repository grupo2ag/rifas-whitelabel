<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Gateway
 *
 * @property int $id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Collection|Raffle[] $raffles
 *
 * @package App\Models
 */
class Gateway extends Model
{
    use HasFactory;

	protected $table = 'gateways';

    public $timestamps = true;

	protected $fillable = [
		'name'
	];

	public function raffles()
	{
		return $this->hasMany(Raffle::class);
	}
}
