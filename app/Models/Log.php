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

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
     protected $dates = ['created_at'];

     /**
      * Get the user associated with the LogTransaction
      *
      * @return \Illuminate\Database\Eloquent\Relations\HasOne
      */
     public function user()
     {
         return $this->hasOne(User::class, 'id', 'user_id');
     }

     /**
      * Save Or Replace Data
      *
      * @param Array $data
      * @return Model|Exception
     */
     public static function saveOrReplace( Array $data )
     {
         try
         {
             return Log::create( $data );
         } catch (QueryException $e)
         {
             throw new \Exception($e->getMessage(), 1);
         }
     }

     /**
      * Construct Log
      *
      * @param App\Models\Model $model
      * @param String $action
      * @param  \Illuminate\Http\Request  $request
      *
      * @return Array
      */
     public static function constructLog( $model, $action, $request = null, $class = null, $id = null )
     {
         return [
             'model'     => $model,
             'user_id'   => (Auth::check() ? Auth::user()->id : 1),
             'action'    => $action,
             'ip'        => ($request ? $request->ip() : Log::getIP()),
             'old_data'  => ($request ? (( $class && $id ) ? json_encode( $class::find( $id )) : '' ) : ''),
             'new_data'  => ($request ? json_encode( $request->all() ) : ''),
             'status'    => Constant::DONE
         ];
     }

     /**
      * Get IP
      * @return String IP
      */

     public static function getIP()
     {
         foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key)
         {
             if (array_key_exists($key, $_SERVER) === true)
             {
                 foreach (explode(',', $_SERVER[$key]) as $ip)
                 {
                     $ip = trim($ip);
                     if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false)
                     {
                         return $ip;
                     }
                 }
             }
         }
         return request()->ip();
     }
 }
