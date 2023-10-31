<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Database;

class EmployeeRole extends Model
{
    use HasFactory, Database;

    protected $fillable = [
        'id',
        'employee_id',
        'role_id'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id' );
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id' );
    }

    public function createData( Array $data )
    {
        return $this->persistCreate( EmployeeRole::class, $data );
    }

    public function updateData( Array $data, $id )
    {
        return $this->persistUpdate( EmployeeRole::class, $data, $id );
    }

    public function deleteData( $id )
    {
        return $this->persistDelete( EmployeeRole::class, $id );
    }

    public function get( $employee_id){
        return $this->where('employee_id', $employee_id)->get();
    }
}
