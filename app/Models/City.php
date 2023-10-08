<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Database;

class City extends Model
{
    use HasFactory, Database;

    protected $fillable = [
        'id',
        'name',
        'department_id'
    ];

    public function Department(){
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    public function employee(){
        return $this->hasMany(Employee::class, 'city_id', 'id');
    }

    public function indexData()
    {
        return $this->persistIndex( City::class );
    }

        public function getData( $id )
    {
        return $this->persistData( City::class, $id );
    }

        public function createData( Array $data )
    {
        return $this->persistCreate( City::class, $data );
    }

    public function updateData( Array $data, $id )
    {
        return $this->persistUpdate( City::class, $data, $id );
    }

        public function deleteData( $id )
    {
        return $this->persistDelete( City::class, $id );
    }
}
