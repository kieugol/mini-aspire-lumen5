<?php

namespace App\Repositories;

use App\Models\RepaymentFrequency;

class RepaymentFrequencyRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return RepaymentFrequency::class;
    }
    
    
    /**
     * Get all valid repayment frequency
     *
     * @return mixed
     */
    public function getAll()
    {
        $result = $this->model
            ->select(['id', 'name', 'value'])
            ->where(RepaymentFrequency::getCol('is_active'), ACTIVE)
            ->get();
        
        return $result;
    }
}
