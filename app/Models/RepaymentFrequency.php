<?php

namespace App\Models;

class RepaymentFrequency extends BaseModel
{
    protected $table = 'repayment_frequency';
    
    protected $fillable = [
        'name',
        'value',
        'is_active',
        'created_by',
        'updated_by'
    ];
}
