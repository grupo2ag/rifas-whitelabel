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
 * Class AffiliateRaffle
 *
 * @property int $affiliate_id
 * @property int $raffle_id
 * @property int $actived
 * @property string $type
 * @property int|null $value
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Affiliate $affiliate
 * @property Raffle $raffle
 * @property Collection|AffiliateGain[] $affiliate_gains
 *
 * @package App\Models
 */
class AffiliateRaffle extends Model
{
    use HasFactory;

	protected $table = 'affiliate_raffles';

    public $timestamps = true;

	public $incrementing = false;

	protected $casts = [
		'affiliate_id' => 'int',
		'raffle_id' => 'int',
		'actived' => 'int',
		'value' => 'int'
	];

	protected $fillable = [
		'actived',
		'type',
		'value'
	];

	public function affiliate()
	{
		return $this->belongsTo(Affiliate::class);
	}

	public function raffle()
	{
		return $this->belongsTo(Raffle::class);
	}

	public function affiliate_gains()
	{
		return $this->hasMany(AffiliateGain::class, 'raffle_id');
	}
}
