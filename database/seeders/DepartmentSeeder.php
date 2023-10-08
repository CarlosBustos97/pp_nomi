<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Department;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Department::insert([
            [ 'country_id' => 1, 'name' => 'Amazonas', 'created_at' => Carbon::now()],
            [ 'country_id' => 1, 'name' => 'Antioquia', 'created_at' => Carbon::now()],
            [ 'country_id' => 1, 'name' => 'Arauca', 'created_at' => Carbon::now()],
            [ 'country_id' => 1, 'name' => 'Atlantico', 'created_at' => Carbon::now()],
            [ 'country_id' => 1, 'name' => 'Bogotá', 'created_at' => Carbon::now()],
            [ 'country_id' => 1, 'name' => 'Bolivar', 'created_at' => Carbon::now()],
            [ 'country_id' => 1, 'name' => 'Boyaca', 'created_at' => Carbon::now()],
            [ 'country_id' => 1, 'name' => 'Caldas', 'created_at' => Carbon::now()],
            [ 'country_id' => 1, 'name' => 'Caqueta', 'created_at' => Carbon::now()],
            [ 'country_id' => 1, 'name' => 'Casanare', 'created_at' => Carbon::now()],
            [ 'country_id' => 1, 'name' => 'Cauca', 'created_at' => Carbon::now()],
            [ 'country_id' => 1, 'name' => 'Cesar', 'created_at' => Carbon::now()],
            [ 'country_id' => 1, 'name' => 'Choco', 'created_at' => Carbon::now()],
            [ 'country_id' => 1, 'name' => 'Cordoba', 'created_at' => Carbon::now()],
            [ 'country_id' => 1, 'name' => 'Cundinamarca', 'created_at' => Carbon::now()],
            [ 'country_id' => 1, 'name' => 'Guainia', 'created_at' => Carbon::now()],
            [ 'country_id' => 1, 'name' => 'Guaviare', 'created_at' => Carbon::now()],
            [ 'country_id' => 1, 'name' => 'Huila', 'created_at' => Carbon::now()],
            [ 'country_id' => 1, 'name' => 'La Guajira', 'created_at' => Carbon::now()],
            [ 'country_id' => 1, 'name' => 'Magdalena', 'created_at' => Carbon::now()],
            [ 'country_id' => 1, 'name' => 'Meta', 'created_at' => Carbon::now()],
            [ 'country_id' => 1, 'name' => 'Nariño', 'created_at' => Carbon::now()],
            [ 'country_id' => 1, 'name' => 'Norte de Santander', 'created_at' => Carbon::now()],
            [ 'country_id' => 1, 'name' => 'Putumayo', 'created_at' => Carbon::now()],
            [ 'country_id' => 1, 'name' => 'Quindio', 'created_at' => Carbon::now()],
            [ 'country_id' => 1, 'name' => 'Risaralda', 'created_at' => Carbon::now()],
            [ 'country_id' => 1, 'name' => 'San Andres', 'created_at' => Carbon::now()],
            [ 'country_id' => 1, 'name' => 'Santander', 'created_at' => Carbon::now()],
            [ 'country_id' => 1, 'name' => 'Sucre', 'created_at' => Carbon::now()],
            [ 'country_id' => 1, 'name' => 'Tolima', 'created_at' => Carbon::now()],
            [ 'country_id' => 1, 'name' => 'Valle', 'created_at' => Carbon::now()],
            [ 'country_id' => 1, 'name' => 'Vaupes', 'created_at' => Carbon::now()],
            [ 'country_id' => 1, 'name' => 'Vichada', 'created_at' => Carbon::now()],
        ]);
    }
}
