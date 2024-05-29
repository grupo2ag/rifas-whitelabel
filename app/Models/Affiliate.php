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
 * @property int $user_id
 *
 * @property User $user
 * @property Collection|Raffle[] $raffles
 *
 * @package App\Models
 */
class Affiliate extends Model
{
    use HasFactory;

	protected $table = 'affiliates';

    public $timestamps = true;

    protected $casts = [
		'user_id' => 'int',
        'id' => 'int'
	];

	protected $fillable = [
        'id',
		'name',
		'link',
		'description',
		'phone',
		'email',
		'document',
		'pix_key',
		'user_id'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function raffles()
	{
		return $this->belongsToMany(Raffle::class, 'affiliate_raffles')
					->withPivot('actived', 'type', 'value')
					->withTimestamps();
	}
    public function affiliate_raffles()
    {
        return $this->hasMany(AffiliateRaffle::class);
    }
    public function scopeOfId($query, $id) {
       return $query->where('id', $id);
    }
    public function scopeOfUserId($query, $userId) {
        return $query->where('user_id', $userId);
    }
}
