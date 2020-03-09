<?php

namespace App\Http\Requests\LoanPayment;

use App\Http\Requests\AbstractRequest;

class LoanPaymentUpdateRequest implements AbstractRequest
{
    public static function rules()
    {
        $statusPaid = LOAN_STATUS_PAID;
        
        return [
            'user'         => 'required|exists:user,id,is_active,1,is_delete,0',
            'loan'         => 'required|exists:loan,id,loan_status_id,!' . $statusPaid,
            'payment_date' => 'required|date',
            'amount'       => 'required|numeric'
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
