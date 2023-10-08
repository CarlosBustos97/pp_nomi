<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Area;
use Illuminate\Database\Seeder;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Area::insert(
            ['name' => 'Marketing y estrategias', 'created_at' => Carbon::now()],
            ['name' => 'Desarrollo', 'created_at' => Carbon::now()],
            ['name' => 'TI', 'created_at' => Carbon::now()],
            ['name' => 'RRHH', 'created_at' => Carbon::now()],
        );
    }
}
