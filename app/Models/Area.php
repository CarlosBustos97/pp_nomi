<?php

namespace App\Models;

use App\Traits\Database;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Area extends Model
{
    use HasFactory, Database;

    protected $fillable = [
        'id',
        'name'
    ];

    public function employees(){
        return $this->hasMany(Employee::class, 'area_id', 'id');
    }

    public function indexData()
    {
        return $this->persistIndex( Area::class );
    }

        public function getData( $id )
    {
        return $this->persistData( Area::class, $id );
    }

        public function createData( Array $data )
    {
        return $this->persistCreate( Area::class, $data );
    }

    public function updateData( Array $data, $id )
    {
        return $this->persistUpdate( Area::class, $data, $id );
    }

        public function deleteData( $id )
    {
        return $this->persistDelete( Area::class, $id );
    }

}
