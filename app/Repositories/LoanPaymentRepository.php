<?php

namespace App\Repositories;

use App\Models\LoanPayment;

class LoanPaymentRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return LoanPayment::class;
    }
    
    protected function getFieldSearchAble()
    {
        return [
            'is_active'  => [
                'field'   => 'is_active',
                'compare' => '=',
                'type'    => 'string',
            ]
        ];
    }
    
    /**
     *  Get list payment by loan id and filter by active status
     *
     * @param       $loanId
     * @param array $params
     *
     * @return mixed
     */
    public function getListByLoanId($loanId, array $params)
    {
        $query = $this->model->select(LoanPayment::getCol('*'));
        $query = $this->addConditionToQuery($query, $params, $this->getFieldSearchAble());
    
        $result = $query->where('loan_id', $loanId)
            ->orderBy('id', 'ASC')
            ->get();
        
        return $result;
    }
    
    /**
     * Get newest payment still not paid by loan id
     *
     * @param $loanId
     *
     * @return mixed
     */
    public function getNewestPaymentNotPaidByLoanId($loanId)
    {
        $result = $this->model
            ->select("*")
            ->where('loan_id', $loanId)
            ->where('is_active', INACTIVE)
            ->orderBy('due_date', 'ASC')
            ->first();
        
        return $result;
    }
    
    /**
     * Get newest payment still not paid by loan id
     *
     * @param $loanId
     *
     * @return mixed
     */
    public function countPaymentNotPaidByLoanId($loanId)
    {
        $result = $this->model
            ->where('loan_id', $loanId)
            ->where('is_active', INACTIVE)
            ->orderBy('due_date', 'ASC')
            ->count();
        
        return $result;
    }
}
