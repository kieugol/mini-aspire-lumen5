<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    
    /**
     * Get primary key name with table alias
     *
     * @return string
     */
    public static function getPriKeyName()
    {
        return (new static)->getTable() . '.' . (new static)->getKeyName();
    }
    
    /**
     *
     * Get column name with table alias
     *
     * @param $column
     *
     * @return string
     */
    public static function getCol($column)
    {
        return (new static)->getTable() . '.' . $column;
    }
    
    /**
     * Get table name
     *
     * @return string
     */
    public static function getTbl()
    {
        return (new static)->getTable();
    }
}
