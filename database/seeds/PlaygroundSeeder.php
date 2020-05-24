<?php

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class PlaygroundSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
/*
        local_names.sql
        exotic_names.sql
        phone_numbers.sql
        company_names.sql
*/
        \App\ThirdPartyApp::create([
            'id' => (string) Str::uuid(),
            'name' => 'Anthony Ereng',
            'email' => 'admin@riversideresidence.org',
            'password' =>  bcrypt('password'),
        ]);

        // in lis
        \App\ThirdPartyApp::create([
            'id' => (string) Str::uuid(),
            'name' => 'System',
            'email' => 'system@his.prod',
            'password' =>  bcrypt('password'),
        ]);

        // in his
        \App\ThirdPartyApp::create([
            'id' => (string) Str::uuid(),
            'name' => 'System',
            'email' => 'system@lis.prod',
            'password' =>  bcrypt('password'),
        ]);

        \App\Models\UserAccess::create([
            'email' => 'admin@schmgtsys.local',
            'password' =>  bcrypt('password'),
        ]);

        \App\Models\UserAccess::create([
            'email' => 'admin@ihsani.dev',
            'password' =>  bcrypt('password'),
        ]);

        // from his to lis
        \App\Models\UserAccess::create([
            'email' => 'system@his.prod',
            'password' =>  bcrypt('password'),
        ]);

        // from lis to his
        \App\Models\UserAccess::create([
            'email' => 'system@lis.prod',
            'password' =>  bcrypt('password'),
        ]);

    	DB::disableQueryLog();
		DB::unprepared(
            file_get_contents(base_path() . "/database/seeds/local_names.sql"));
    	DB::enableQueryLog();
        $this->command->info('Names with Gender Seeded!');
    }
}
