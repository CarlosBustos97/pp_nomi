<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Position;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Position::insert([
            ['name' => 'Director creativo', 'created_at' => Carbon::now()],
            ['name' => 'Desarrollador Jr', 'created_at' => Carbon::now()],
            ['name' => 'Desarrollador Diseñador Jr', 'created_at' => Carbon::now()]
        ]);
    }
}
