<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Country;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Country::insert([
            ['name' => 'Colombia', 'created_at' => Carbon::now()],
            ['name' => 'Argentina', 'created_at' => Carbon::now()],
        ]);
    }
}
