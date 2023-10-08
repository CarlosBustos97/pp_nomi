<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Database;

class EmployeePosition extends Model
{
    use HasFactory, Database;

    protected $fillable = [
        'id',
        'employee_id',
        'position_id'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id' );
    }

    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id', 'id' );
    }
}
