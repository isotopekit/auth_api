<?php

namespace IsotopeKit\AuthAPI\Models;

use Illuminate\Database\Eloquent\Model;

class Levels extends Model
{
	protected $table = 'levels';

	protected $fillable = [
		'name', 'price', 'agency_members'
	];
}
