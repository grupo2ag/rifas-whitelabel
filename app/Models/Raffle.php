<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Raffle
 *
 * @property int $id
 * @property string $title
 * @property string|null $subtitle
 * @property int $pix_expired
 * @property int $buyer_ranking
 * @property string $link
 * @property int $price
 * @property string $status
 * @property int $quantity
 * @property string|null $numbers
 * @property string $type
 * @property int $highlight
 * @property int $minimum_purchase
 * @property int $maximum_purchase
 * @property int $visible
 * @property int $user_id
 * @property int $partial
 * @property string|null $description
 * @property string|null $video
 * @property int $gateway_id
 * @property int $total
 *
 * @property User $user
 * @property Gateway $gateway
 * @property Collection|Participant[] $participants
 * @property Collection|Affiliate[] $affiliates
 * @property Collection|RaffleAward[] $raffle_awards
 * @property Collection|RaffleImage[] $raffle_images
 * @property Collection|RafflePromotion[] $raffle_promotions
 *
 * @package App\Models
 */
class Raffle extends Model
{
    use HasFactory;

	protected $table = 'raffles';
	public $timestamps = false;

	protected $casts = [
		'pix_expired' => 'int',
		'buyer_ranking' => 'int',
		'price' => 'int',
		'quantity' => 'int',
		'highlight' => 'int',
		'minimum_purchase' => 'int',
		'maximum_purchase' => 'int',
		'visible' => 'int',
		'user_id' => 'int',
		'partial' => 'int',
		'gateway_id' => 'int',
		'total' => 'int'
	];

	protected $fillable = [
		'title',
		'subtitle',
		'pix_expired',
		'buyer_ranking',
		'link',
		'price',
		'status',
		'quantity',
		'numbers',
		'type',
		'highlight',
		'minimum_purchase',
		'maximum_purchase',
		'visible',
		'user_id',
		'partial',
		'description',
		'video',
		'gateway_id',
		'total'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function gateway()
	{
		return $this->belongsTo(Gateway::class);
	}

	public function participants()
	{
		return $this->hasMany(Participant::class);
	}

	public function affiliates()
	{
		return $this->belongsToMany(Affiliate::class, 'affiliate_raffles')
					->withPivot('actived', 'type', 'value')
					->withTimestamps();
	}

	public function raffle_awards()
	{
		return $this->hasMany(RaffleAward::class);
	}

	public function raffle_images()
	{
		return $this->hasMany(RaffleImage::class);
	}

	public function raffle_promotions()
	{
		return $this->hasMany(RafflePromotion::class);
	}


}
