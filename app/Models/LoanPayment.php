<?php

namespace App\Models;

class LoanPayment extends BaseModel
{
    protected $table = 'loan_payment';
    
    protected $fillable = [
        'loan_id',
        'due_date',
        'principal_amount',
        'interest_amount',
        'amount',
        'balance',
        'remarks',
        'is_active',
        'created_by',
        'updated_by'
    ];
}
