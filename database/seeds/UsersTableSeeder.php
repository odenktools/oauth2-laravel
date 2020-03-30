<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    private $userModel;

    private $companyModel;

    public function __construct()
    {
        $this->userModel = new \App\User;
        $this->companyModel = new \App\Models\Company;
    }

    public function run()
    {
        $company = $this->companyModel->create([
            'code' => 'odenktools-' . Str::random(5),
            'name' => 'odenktools corporate'
        ]);

        $this->userModel->create([
            'company_id' => $company->id,
            'name' => 'odenktools',
            'email' => 'odenktools@gmail.com',
            'password' => bcrypt('qwerty'),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10)
        ]);
    }
}
