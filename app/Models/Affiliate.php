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
 * Class Affiliate
 *
 * @property int $id
 * @property string $name
 * @property string $phone
 * @property string $email
 * @property string $document
 * @property string $pix_key
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Collection|Raffle[] $raffles
 *
 * @package App\Models
 */
class Affiliate extends Model
{
    use HasFactory;

	protected $table = 'affiliates';

	protected $fillable = [
		'name',
		'phone',
		'email',
		'document',
		'pix_key'
	];

	public function raffles()
	{
		return $this->belongsToMany(Raffle::class, 'affiliate_raffles')
					->withPivot('actived', 'type', 'value')
					->withTimestamps();
	}
}
