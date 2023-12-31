<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use Carbon\Carbon;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::insert([
            ['name' => 'Jefe', 'created_at' => Carbon::now()],
            ['name' => 'Colaborador', 'created_at' => Carbon::now()]
        ]);
    }
}
