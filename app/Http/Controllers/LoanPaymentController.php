<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoanPayment\{LoanPaymentUpdateRequest};
use App\Services\LoanPaymentService;
use Illuminate\Http\Request;

class LoanPaymentController extends BaseController
{
    protected $loanPaymentService;
    
    public function __construct(Request $request, LoanPaymentService $loanPaymentService)
    {
        parent::__construct($request);
        
        $this->loanPaymentService = $loanPaymentService;
    }
    
    public function getListByLoan($loanId)
    {
        $result = $this->loanPaymentService->getListByLoanId($loanId, $this->request);
        
        return $this->sendResponse($result[RESPONSE_KEY], $result[STT_CODE_KEY]);
    }
    
    /**
     * Add a payment for one specific month
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function repayment()
    {
        $this->validate($this->request, LoanPaymentUpdateRequest::rules(), LoanPaymentUpdateRequest::messages());
        
        $result = $this->loanPaymentService->repayment($this->request);
        
        return $this->sendResponse($result[RESPONSE_KEY], $result[STT_CODE_KEY]);
    }
}
