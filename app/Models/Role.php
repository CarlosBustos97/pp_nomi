<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Database;

class Role extends Model
{
    use HasFactory, Database;
    protected $fillable = [
        'id',
        'name'
    ];

    public function indexData()
    {
        return $this->persistIndex( Role::class );
    }

        public function getData( $id )
    {
        return $this->persistData( Role::class, $id );
    }

        public function createData( Array $data )
    {
        return $this->persistCreate( Role::class, $data );
    }

    public function updateData( Array $data, $id )
    {
        return $this->persistUpdate( Role::class, $data, $id );
    }

        public function deleteData( $id )
    {
        return $this->persistDelete( Role::class, $id );
    }
}
