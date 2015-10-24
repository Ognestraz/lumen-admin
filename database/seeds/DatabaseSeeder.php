<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
                        Model::unguard();

                        $this->call('UserSeeder');
                        $this->command->info('User seeded!');
                        $this->call('SiteSeeder');
                        $this->command->info('Site seeded!');
                        $this->call('BlockSeeder');
                        $this->command->info('Block seeded!');
                        $this->call('MenuSeeder');
                        $this->command->info('Menu seeded!');
                        $this->call('ImageSeeder');
                        $this->command->info('Images seeded!');
                        $this->call('VideoSeeder');
                        $this->command->info('Videos seeded!');
                        $this->call('FileSeeder');
                        $this->command->info('Files seeded!');
                        
	}

}
