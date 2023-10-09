<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Database;

class Position extends Model
{
    use HasFactory, Database;
    protected $fillable = [
        'id',
        'name'
    ];

    public function employees()
    {
        return $this->hasMany(Employee::class, 'position_id', 'id');
    }

    public function indexData()
    {
        return $this->persistIndex( Position::class );
    }

        public function getData( $id )
    {
        return $this->persistData( Position::class, $id );
    }

        public function createData( Array $data )
    {
        return $this->persistCreate( Position::class, $data );
    }

    public function updateData( Array $data, $id )
    {
        return $this->persistUpdate( Position::class, $data, $id );
    }

        public function deleteData( $id )
    {
        return $this->persistDelete( Position::class, $id );
    }
}
