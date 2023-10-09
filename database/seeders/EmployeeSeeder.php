<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employee;
use Carbon\Carbon;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Employee::insert([
            [
                'birth_city_id' => 1,
                'area_id' => 1,
                'position_id' => 1,
                'user_id' => 2,
                'name' => 'Carlos Bustos',
                'identification' => 1234679,
                'address' => 'calle 90 #12-20',
                'cellphone' => "4652358",
                'created_at' => Carbon::now(),
            ]
        ]);
    }
}
