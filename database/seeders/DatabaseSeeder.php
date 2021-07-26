<?php

namespace IsotopeKit\AuthAPI\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use IsotopeKit\AuthAPI\Models\User;
use IsotopeKit\AuthAPI\Models\User_Role;
use IsotopeKit\AuthAPI\Models\Levels;
use IsotopeKit\AuthAPI\Models\Site;

class DatabaseSeeder extends Seeder
{
	/**
	 * Seed the application's database.
	 *
	 * @return void
	 */
	public function run()
	{
		// \App\Models\User::factory(10)->create();

		User::insert([
			"first_name"	=> "Super",
			"last_name" 	=> "Admin",
			"email"			=> "admin@gmail.com",
			"enabled"		=> true,
			'password'		=> bcrypt('password'),
		]);

		User_Role::insert([
			'user_id'	=>	'1',
			'levels'	=>	'["0"]'
		]);

		Site::insert([
			'language'	=>	'en',
			'theme'		=>	'blue',
			'name'		=>	'IsotopeKit',
			'agency_id'	=>	'1'
		]);

		Levels::insert([
			'name'			=>	'core',
			'valid_time'	=>	'365',
			'enabled'		=> 	false
		]);
	}
}
