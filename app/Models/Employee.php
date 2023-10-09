<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Database;

class Employee extends Model
{
    use HasFactory, Database;

    protected $fillable = [
        'id',
        'birth_city_id',
        'manager_id',
        'user_id',
        'area_id',
        'position_id',
        'role_id',
        'name',
        'identification',
        'address',
        'cellphone'
    ];

    public function city()
    {
        return $this->belongsTo(City::class, 'birth_city_id', 'id' );
    }

    public function manager()
    {
        return $this->belongsTo(Employee::class, 'manager_id', 'id' );
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id' );
    }

    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id', 'id' );
    }

    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id', 'id' );
    }

    public function employeeRoles()
    {
        return $this->hasMany(EmployeeRole::class, 'employee_id', 'id');
    }

    public function indexData()
    {
        return Employee::get();
        return $this->persistIndex( Employee::class );
    }

        public function getData( $id )
    {
        return $this->persistData( Employee::class, $id );
    }

        public function createData( Array $data )
    {
        return $this->persistCreate( Employee::class, $data );
    }

    public function updateData( Array $data, $id )
    {
        return $this->persistUpdate( Employee::class, $data, $id );
    }

        public function deleteData( $id )
    {
        return $this->persistDelete( Employee::class, $id );
    }
}
