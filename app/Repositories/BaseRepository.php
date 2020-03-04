<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Prettus\Repository\Eloquent\BaseRepository as L5Repository;

/**
 * Class BaseRepository
 * @package App\Repositories
 */
abstract class BaseRepository extends L5Repository
{
    /**
     * @var array $limitPerPage The limitation of record on per page
     */
    protected $limitPerPage = [10, 20, 30, 40, 50, 100, 200];
    
    /**
     * @var array $softAble Allowing order asc or desc
     */
    protected $orderAble = ['DESC', 'desc', 'ASC', 'asc'];
    
    /**
     * @param LengthAwarePaginator $data
     *
     * @return array
     */
    public function formatPagination(LengthAwarePaginator $data)
    {
        $length      = $data->perPage();
        $totalRecord = $data->total();
        $result      = [
            'page'         => $data->currentPage(),
            'length'       => $length,
            'total_record' => $totalRecord,
            'total_page'   => ceil($totalRecord / $length),
            'rows'         => $data->items(),
        ];
        
        return $result;
    }
    
    /**
     * @param $query
     * @param $search
     * @param $fieldSearch
     *
     * @return mixed
     */
    protected function addConditionToQuery($query, $search, $fieldSearch)
    {
        if (!$search) {
            return $query;
        }
        
        foreach ($search as $key => $val) {
            if (!isset($fieldSearch[$key]) || empty($val)) {
                continue;
            }
            
            $field = $fieldSearch[$key]['field'];
            switch ($fieldSearch[$key]['type']) {
                case 'string':
                    $compare = empty($fieldSearch[$key]['compare']) ? 'like' : $fieldSearch[$key]['compare'];
                    
                    if (strtolower(trim($compare)) == 'like') {
                        $val = '%' . $val . '%';
                    }
                    $query->where(DB::raw($fieldSearch[$key]['field']), $compare, $val);
                    
                    break;
                
                case 'date':
                    $val        = str_replace('"', '', $val);
                    $dateFormat = date('Y-m-d', strtotime($val));
                    $query->where(
                        DB::raw('DATE(' . $field . ')'), $fieldSearch[$key]['compare'], $dateFormat);
                    break;
                
                case 'array':
                    $delimiter = empty($fieldSearch[$key]['delimiter']) ? "," : $fieldSearch[$key]['delimiter'];
                    $val       = explode($delimiter, $val);
                    $query->whereIn($field, $val);
                    break;
                
                default:
                    $query->where($fieldSearch[$key]['field'], $fieldSearch[$key]['compare'], $val);
                    break;
            }
        }
        
        return $query;
    }
}
