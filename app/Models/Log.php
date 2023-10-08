<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Database;

class Log extends Model
{
    use HasFactory, Database;

    protected $fillable = [
        'id',
        'model',
        'user_id',
        'action',
        'ip',
        'old_data',
        'new_data',
        'detail'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'User', 'id' );
    }

    public function indexData()
    {
        return $this->persistIndex( Log::class );
    }

        public function getData( $id )
    {
        return $this->persistData( Log::class, $id );
    }

        public function createData( Array $data )
    {
        return $this->persistCreate( Log::class, $data );
    }

    public function updateData( Array $data, $id )
    {
        return $this->persistUpdate( Log::class, $data, $id );
    }

        public function deleteData( $id )
    {
        return $this->persistDelete( Log::class, $id );
    }
}
