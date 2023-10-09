<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
            [
                'name' => 'admin',
                'email' => 'admin@alianza.com',
                'password' => bcrypt(123),
                'remember_token' => User::generateVerificationToken(),
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'Carlos Bustos',
                'email' => 'carlobustos@alianza.com',
                'password' => bcrypt(123),
                'remember_token' => User::generateVerificationToken(),
                'created_at' => Carbon::now()
            ]
        ]);
    }
}
