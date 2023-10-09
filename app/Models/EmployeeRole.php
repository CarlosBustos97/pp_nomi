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
}
