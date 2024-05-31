<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ResultsFederal
 * 
 * @property int $id
 * @property Carbon $date
 * @property string|null $local
 * @property string $concurso
 * @property string $results
 * @property string $r1
 * @property string $r2
 * @property string $r3
 * @property string $r4
 * @property string $r5
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class ResultsFederal extends Model
{
	protected $table = 'results_federal';

	protected $casts = [
		'date' => 'datetime'
	];

	protected $fillable = [
		'date',
		'local',
		'concurso',
		'results',
		'r1',
		'r2',
		'r3',
		'r4',
		'r5'
	];
}
