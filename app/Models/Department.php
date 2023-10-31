<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Database;

class Department extends Model
{
    use HasFactory, Database;

    protected $fillable = [
        'id',
        'country_id',
        'name'
    ];

    public function cities(){
        return $this->hasMany(City::class, 'department_id', 'id' );
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id' );
    }

    public function indexData()
    {
        return $this->persistIndex( Department::class );
    }

        public function getData( $id )
    {
        return $this->persistData( Department::class, $id );
    }

        public function createData( Array $data )
    {
        return $this->persistCreate( Department::class, $data );
    }

    public function updateData( Array $data, $id )
    {
        return $this->persistUpdate( Department::class, $data, $id );
    }

        public function deleteData( $id )
    {
        return $this->persistDelete( Department::class, $id );
    }
}
