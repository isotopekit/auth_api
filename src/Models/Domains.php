<?php

namespace IsotopeKit\AuthAPI\Models;

use Illuminate\Database\Eloquent\Model;

class Domains extends Model
{
	protected $table = 'domains';

	protected $fillable = [
		'url', 'use_type', 'user_id', 'page_id', 'checked', 'has_error', 'is_secured'
	];
}
