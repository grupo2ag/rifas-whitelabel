<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserConfiguration
 *
 * @property int $id
 * @property string|null $primary_color
 * @property string|null $logo
 * @property string|null $meta_description
 * @property string|null $meta_keywords
 * @property string|null $meta_image
 * @property string|null $favicon
 * @property string|null $site_title
 * @property string|null $site_subtitle
 * @property string|null $privacy
 * @property string|null $about_us
 * @property string|null $terms_conditions
 * @property string|null $facebook
 * @property string|null $instagram
 * @property string|null $twitter
 * @property string|null $youtube
 * @property string|null $google_analytics
 * @property string|null $facebook_pixel
 * @property int $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property User $user
 *
 * @package App\Models
 */
class UserConfiguration extends Model
{
    use HasFactory;

	protected $table = 'user_configurations';
	public $incrementing = true;

    public $timestamps = true;

	protected $casts = [
		'id' => 'int',
		'user_id' => 'int'
	];

	protected $fillable = [
		'primary_color',
		'logo',
		'meta_description',
		'meta_keywords',
		'meta_image',
		'favicon',
		'site_title',
		'site_subtitle',
		'privacy',
		'about_us',
		'terms_conditions',
		'facebook',
		'instagram',
		'twitter',
		'youtube',
		'google_analytics',
		'facebook_pixel',
		'user_id',
		'whatsapp',
		'telegram'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
