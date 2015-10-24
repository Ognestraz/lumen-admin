<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
                        BaseModel::unguard();

                        DB::table('users')->truncate();
                        Model\User::create([
                            'act' => '1',
                            'role_id' => '1',
                            'email' => 'admin@mail.ru',
                            'name' => 'admin',
                            'password' => 'nthvf8vg8akfq'
                        ]);
                        
                        Model\User::create([
                            'act' => '1',
                            'role_id' => '2',
                            'email' => 'moderator@mail.ru',
                            'name' => 'moderator',
                            'password' => 'moderator'
                        ]);
                        
                        Model\User::create([
                            'act' => '1',
                            'role_id' => '3',
                            'email' => 'user1@mail.ru',
                            'name' => 'user1',
                            'password' => 'user1'
                        ]);
                        
                        Model\User::create([
                            'act' => '1',
                            'role_id' => '3',
                            'email' => 'user2@mail.ru',
                            'name' => 'user2',
                            'password' => 'user2'
                        ]);                        
                        
	}

}
