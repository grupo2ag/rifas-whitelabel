<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Customer
 * 
 * @property int $id
 * @property string|null $name
 * @property string|null $phone
 * @property string|null $email
 * @property string|null $cpf
 *
 * @package App\Models
 */
class Customer extends Model
{
	protected $table = 'customers';
	public $timestamps = false;

	protected $fillable = [
		'name',
		'phone',
		'email',
		'cpf'
	];
}
