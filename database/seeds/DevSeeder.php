<?php

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class DevSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\ThirdPartyApp::create([
            'id' => (string) Str::uuid(),
            'name' => 'ML4Afrika',
            'email' => 'ml4afrika@play.dev',
            'password' =>  bcrypt('password'),
        ]);

        \App\ThirdPartyApp::create([
            'id' => (string) Str::uuid(),
            'name' => 'Medbook',
            'email' => 'medbook@play.dev',
            'password' =>  bcrypt('password'),
        ]);


        \App\ThirdPartyApp::create([
            'id' => (string) Str::uuid(),
            'name' => 'Sanitas',
            'email' => 'sanitas@play.dev',
            'password' =>  bcrypt('password'),
        ]);
    }
}
