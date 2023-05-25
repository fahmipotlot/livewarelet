<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
	    	[
			    'email' => 'user@localhost.com',
	    	],
	    	[
	    		'name' => 'user',
			    'email' => 'user@localhost.com',
			    'password' => bcrypt('user')
	    	]
	    );
    }
}
