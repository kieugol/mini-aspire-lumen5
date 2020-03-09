<?php

namespace App\Repositories;

use App\Models\Loan;
use App\Models\LoanStatus;
use App\Models\RepaymentFrequency;

class LoanRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Loan::class;
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
            ->select([
                loan::getCol("id"),
                "user_id",
                "term",
                "start_date",
                "end_date",
                RepaymentFrequency::getCol('name as repayment_frequency'),
                LoanStatus::getCol('name as Loan_status'),
                "interest_rate",
                "amount",
                "payment_amount",
                "interest_amount",
                "remarks",
                loan::getCol("created_at"),
                loan::getCol("updated_at"),
            ])
            ->join(RepaymentFrequency::getTbl(), RepaymentFrequency::getCol('id'), '=', 'repayment_frequency_id')
            ->join(LoanStatus::getTbl(), LoanStatus::getCol('id'), '=', 'loan_status_id')
            ->orderBy($order, $sort)
            ->paginate($length);
        
        return $this->formatPagination($query);
    }
    
    public function getListByUserId($userId)
    {
        $result = $this->model
            ->select([
                loan::getCol("id"),
                "user_id",
                "term",
                "start_date",
                "end_date",
                RepaymentFrequency::getCol('name as repayment_frequency'),
                LoanStatus::getCol('name as Loan_status'),
                "interest_rate",
                "amount",
                "payment_amount",
                "interest_amount",
                "remarks",
                loan::getCol("created_at"),
                loan::getCol("updated_at"),
            ])
            ->join(RepaymentFrequency::getTbl(), RepaymentFrequency::getCol('id'), '=', 'repayment_frequency_id')
            ->join(LoanStatus::getTbl(), LoanStatus::getCol('id'), '=', 'loan_status_id')
            ->where('user_id', $userId)
            ->get();
        
        return $result;
    }
}
