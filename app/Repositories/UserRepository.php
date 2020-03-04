<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }
    
    public function getList($params)
    {
        $order  = 'id';
        $length = $this->getLength($params);
        $sort   = $this->getOrder($params);
        
        $query = $this->model
            ->select("*")
            ->where(User::getCol('is_delete'), '<>', STATUS_ACTIVE)
            ->where(User::getCol('username'), '<>', ROLES_ROOT_NAME)
            ->orderBy($order, $sort)
            ->with(['roles', 'user'])
            ->paginate($length);
        
        return $this->formatPagination($query);
    }
    
    public function getAll()
    {
        $query = $this->model
            ->select("*")
            ->where(User::getCol('username'), '<>', ROLES_ROOT_NAME)
            ->where(User::getCol('is_delete'), '<>', STATUS_ACTIVE)
            ->with(['roles', 'user'])
            ->get();
        
        return $query;
    }
    
    public function getDetail($id)
    {
        $query = $this->model
            ->select("*")
            ->where(User::getCol('username'), '<>', ROLES_ROOT_NAME)
            ->where(User::getCol('is_delete'), '<>', STATUS_ACTIVE)
            ->where(User::getCol('id'), $id)
            ->with([
                'roles' => function($subQuery) {
                    $subQuery->select('id','name');
                },
                'user_client' =>  function($subQuery) {
                    $subQuery->select('client_id', 'user_id');
                }
            ])
            ->first();
        
        return $query;
    }
    
    public function getUserForDelete($id)
    {
        $query = $this->model
            ->select("*")
            ->where(User::getCol('id'), $id)
            ->where(User::getCol('is_delete'), '<>', STATUS_ACTIVE)
            ->where(User::getCol('username'), '<>', ROLES_ROOT_NAME)
            ->first();
        
        return $query;
    }
}
