<?php

namespace App\Http\Requests\Loan;

use App\Http\Requests\AbstractRequest;

class LoanCreateRequest implements AbstractRequest
{
    public static function rules()
    {
        return [
            'user'                => 'required|exists:user,id,is_active,1,is_delete,0',
            'repayment_frequency' => 'required|exists:repayment_frequency,id',
            'loan_term'           => 'required|integer|min:1|max:100',
            'interest_rate'       => 'required|numeric|min:0',
            'amount'              => 'required|integer|min:1000'
        ];
    }
    
    /**
     * @return array
     */
    public static function messages()
    {
        return [];
    }
}
