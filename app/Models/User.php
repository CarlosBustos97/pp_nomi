<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Database\Traits\Database;
use App\Traits\Database;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Database;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
        'email_verified_at',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function indexData()
    {
        return $this->persistIndex( User::class );
    }

        public function getData( $id )
    {
        return $this->persistData( User::class, $id );
    }

        public function createData( Array $data )
    {
        return $this->persistCreate( User::class, $data );
    }

    public function updateData( Array $data, $id )
    {
        return $this->persistUpdate( User::class, $data, $id );
    }

        public function deleteData( $id )
    {
        return $this->persistDelete( User::class, $id );
    }
}
