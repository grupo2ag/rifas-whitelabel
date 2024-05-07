<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LogError
 *
 * @property int $id
 * @property string|null $exception
 * @property string|null $payload
 * @property string|null $table
 * @property string|null $comment
 * @property string|null $id_reference
 * @property int|null $users_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class LogError extends Model
{
	protected $table = 'log_errors';

    public $timestamps = true;

	protected $casts = [
		'users_id' => 'int'
	];

	protected $fillable = [
		'exception',
		'payload',
		'table',
		'comment',
		'id_reference',
		'users_id'
	];
}
