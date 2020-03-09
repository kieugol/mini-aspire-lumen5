<?php

namespace App\Repositories;

use App\Models\User;

/**
 * Class UserRepository
 * @package App\Repositories
 */
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
    
    /**
     * Get list user with pagination
     *
     * @param $params
     *
     * @return array
     */
    public function getList($params)
    {
        $order  = $this->getSortColumn($params);
        $length = $this->getLength($params);
        $sort   = $this->getOrder($params);
        
        $query = $this->model
            ->select("*")
            ->where(User::getCol('is_active'), ACTIVE)
            ->where(User::getCol('is_delete'), INACTIVE)
            ->orderBy($order, $sort)
            ->paginate($length);
        
        return $this->formatPagination($query);
    }
    
    /**
     * Get all valid user
     *
     * @return mixed
     */
    public function getAll()
    {
        $result = $this->model
            ->select(['id', 'name', 'email', 'phone'])
            ->where(User::getCol('is_active'), ACTIVE)
            ->where(User::getCol('is_delete'), INACTIVE)
            ->get();
        
        return $result;
    }
}
