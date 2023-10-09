<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EmployeeRole;

class EmployeeRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EmployeeRole::insert([
            'employee_id'   => 1,
            'role_id'   => 1
        ]);
    }
}
