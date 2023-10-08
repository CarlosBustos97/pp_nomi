<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Database;

class Country extends Model
{
    use HasFactory, Database;

    protected $fillable = [
        'id',
        'name'
    ];

    public function departments(){
        return $this->hasMany(Departments::class, 'country_id', 'id' );
    }

    public function indexData()
    {
        return $this->persistIndex( Country::class );
    }

        public function getData( $id )
    {
        return $this->persistData( Country::class, $id );
    }

        public function createData( Array $data )
    {
        return $this->persistCreate( Country::class, $data );
    }

    public function updateData( Array $data, $id )
    {
        return $this->persistUpdate( Country::class, $data, $id );
    }

        public function deleteData( $id )
    {
        return $this->persistDelete( Country::class, $id );
    }
}
