<?php

namespace App\Traits;

use App\Constant;
use App\Models\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;

trait Database
{

    /**
     * Query a model and return it
     *
     * @param Illuminate\Database\Eloquent\Model $class
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function persistIndex( $class, $status = Constant::ACTIVE, $sort_by = null, $sort_type = 'ASC' )
    {
        try
        {
            if( $status === 'all' )
                $model = $class::whereIn('status', [Constant::ACTIVE, Constant::INACTIVE]);
            else
                $model = $class::where('status', $status);

            if( $sort_by )
                $model->orderBy( $sort_by, $sort_type);

            $response = $model->get();

            if( $response )
            {
                $this->logTransactions( $class, '', ($response->count() < Constant::MAX_INDEX_DATA ? $response : []), Constant::INDEX, 'Listando datos');
            }
            else
            {
                $this->logTransactions( $class, '', '', Constant::INDEX, 'No se encontraron datos para listar', Constant::FAIL);
                abort(404);
            }
            return $response;
        }catch( QueryException $e )
        {
            $this->logTransactions( $class, '', '', Constant::INDEX, $e->getMessage(), Constant::FAIL);
            abort(500);
        }
    }

    /**
     * Query a model and return it
     *
     * @param Illuminate\Database\Eloquent\Model $class
     * @param Int $id
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    public function persistData( $class, $id )
    {
        try
        {
            $model = $class::find( $id );
            if( $model )
                $this->logTransactions( $class, '', '', Constant::SHOW, 'Mostrando dato');
            else
            {
                $this->logTransactions( $class, '', '', Constant::SHOW, 'No se encontró la información', Constant::FAIL);
                abort(404);
            }
            return $model;
        }catch( QueryException $e )
        {
            $this->logTransactions( $class, '', '', Constant::SHOW, $e->getMessage(), Constant::FAIL);
            abort(500);
        }
    }

    /**
     * Save a model and return it
     *
     * @param Illuminate\Database\Eloquent\Model $class
     * @param Array $data
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    public function persistCreate( $class, Array $data )
    {
        try
        {
            $model = new $class;
            $model->fill( $data );
            $model->save();
            if( $model )
                $this->logTransactions( $class, '', $model, Constant::STORE, 'Creando datos');
            else
            {
                $this->logTransactions( $class, '', '', Constant::STORE, 'No se pudo guardar la información', Constant::FAIL);
                abort(400);
            }
            return $model;

        }catch( QueryException $e )
        {
            dd($e);
            $this->logTransactions( $class, '', '', Constant::STORE, $e->getMessage(), Constant::FAIL);
            abort(500);
        }
    }

    /**
     * Update a model and return it
     *
     * @param Illuminate\Database\Eloquent\Model $class
     * @param Array $data
     * @param Int $id
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    public function persistUpdate( $class, Array $data, $id )
    {
        try
        {
            $model = $class::find( $id );
            if( $model )
            {
                $old_data = $class::find( $id );
                $response = $model;
                $model->update( $data );
                $this->logTransactions( $class, $old_data, $response, Constant::UPDATE, 'Actualizando datos');
            }
            else
            {
                $this->logTransactions( $class, '', '', Constant::UPDATE, 'No se encontró información para ser actualizada', Constant::FAIL);
            }
            return isset($response) ? $response : $model;

        }catch( QueryException $e )
        {
            dd($e->getMessage());
            $this->logTransactions( $class, '', '', Constant::UPDATE, $e->getMessage(), Constant::FAIL);
            abort(500);
        }
    }


    /**
     * Validate custom query and return it
     *
     * @param Illuminate\Database\Eloquent\Model $class
     * @param Illuminate\Database\Eloquent\Collection $collection
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    public function persistCustomGetData( $class, $collection )
    {
        try
        {
            if( $collection )
                $this->logTransactions( $class, '', '', Constant::SHOW, 'Datos encontrados');
            else
            {
                $this->logTransactions( $class, '', '', Constant::SHOW, 'No se pudo encontrar la información', Constant::FAIL);
                abort(404);
            }
            return $collection;

        }catch( QueryException $e )
        {
            $this->logTransactions( $class, '', '', Constant::SHOW, $e->getMessage(), Constant::FAIL);
            abort(500);
        }
    }

    /**
     * Delete data
     *
     * @param Illuminate\Database\Eloquent\Model $class
     * @param Int $id
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    public function persistDelete( $class, $id )
    {
        try
        {
            $model = $class::find( $id );
            if( $model )
            {
                $response = $model->delete();
                $this->logTransactions( $class, $model, $response, Constant::DELETE, 'Eliminando datos');
            }
            else
            {
                $this->logTransactions( $class, '', '', Constant::DELETE, 'No se pudo encontrar el dato para la eliminación', Constant::FAIL);
                abort(404);
            }
            return $model;

        }catch( QueryException $e )
        {
            $this->logTransactions( $class, '', '', Constant::DELETE, $e->getMessage(), Constant::FAIL);
            abort(500);
        }
    }

    /**
     * Create Database Local Log
     *
     * @param Illuminate\Database\Eloquent\Model $class
     * @param Illuminate\Database\Eloquent\Model $model
     * @param Array $data
     * @param String $action
     * @param String $status
     *
     */
    public function logTransactions( $class, $old_data, $new_data, $action = 'store', $detail = '', $status = Constant::DONE )
    {
        $log_transaction = new Log();
        $log_transaction->fill([
            'model'     => $class,
            'user_id'   => (Auth::check() ? Auth::user()->id : 1 ),
            'action'    => $action,
            'ip'        => Log::getIP(),
            'old_data'  => json_encode( $old_data ),
            'new_data'  => json_encode( $new_data ),
            'detail'    => $detail,
            'status'    => $status
        ]);
        $log_transaction->save();

    }
}
