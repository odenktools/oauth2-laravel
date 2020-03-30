<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserTableSeeder extends Seeder
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new \App\User;
    }

    public function run()
    {
        $this->userModel->create([
            'name' => 'odenktools',
            'email' => 'odenktools@gmail.com',
            'password' => bcrypt('qwerty'),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10)
        ]);
    }
}
