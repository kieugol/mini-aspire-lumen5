<?php

namespace App\Models;

class LoanStatus extends BaseModel
{
    protected $table = 'loan_status';
    
    protected $fillable = [
        'name',
        'is_active',
        'created_by',
        'updated_by'
    ];
}
