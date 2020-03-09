<?php

namespace App\Models;

class Loan extends BaseModel
{
    protected $table = 'loan';
    
    protected $fillable = [
        'user_id',
        'loan_status_id',
        'repayment_frequency_id',
        'start_date',
        'end_date',
        'term',
        'amount',
        'interest_rate',
        'payment_amount',
        'interest_amount',
        'remarks',
        'created_by',
        'updated_by'
    ];
    
    
    public function loan_payment()
    {
        return $this->hasMany(LoanPayment::class, 'loan_id')->select(['id', 'date_payment', 'amount_payment', 'remarks']);
    }
    
    public function repayment_frequency()
    {
        return $this->hasOne(RepaymentFrequency::class, 'id', 'repayment_frequency_id')->select(['id', 'name', 'value']);
    }
    
    public function loan_status()
    {
        return $this->hasOne(LoanStatus::class, 'id', 'loan_status_id')->select(['id', 'name']);
    }
}
