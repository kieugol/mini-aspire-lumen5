<?php

namespace App\Services;

use App\Repositories\{LoanRepository, LoanPaymentRepository};
use Illuminate\Http\{Request, Response};

class LoanPaymentService extends BaseService
{
    protected $loanRep;
    protected $loanPaymentRep;
    
    public function __construct(LoanRepository $loanRep, LoanPaymentRepository $loanPaymentRep)
    {
        $this->loanRep        = $loanRep;
        $this->loanPaymentRep = $loanPaymentRep;
    }
    
    /**
     * Get list payment by load id
     *
     * @param         $loanId
     * @param Request $request
     *
     * @return array
     */
    public function getListByLoanId($loanId, Request $request)
    {
        $this->setData($this->loanPaymentRep->getListByLoanId($loanId, $request->all()));
        
        return $this->getResponseData();
    }
    
    /**
     * Add payment by period for loan
     *
     * @param Request $request
     *
     * @return array
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function repayment(Request $request)
    {
        $loanDetail = $this->loanRep->findWhere(['id' => $request['loan'], 'user_id' => $request['user']]);
        if (empty($loanDetail)) {
            abort(Response::HTTP_BAD_REQUEST, trans('message.loan_not_exist'));
        }
        
        $paymentDate       = date("Y-m-d", strtotime($request['payment_date']));
        $loanPaymentDetail = $this->loanPaymentRep->getNewestPaymentNotPaidByLoanId($request['loan']);
        $totalPayment      = $this->loanPaymentRep->countPaymentNotPaidByLoanId($request['loan']);
        $fromDate          = date('Y-m-01', strtotime($loanPaymentDetail->due_date));
        $loanStatus        = $totalPayment == 1 ? LOAN_STATUS_PAID : LOAN_STATUS_PAYING; // if only one payment update loan to PAID otherwise PAYING
        
        if (!($paymentDate >= $fromDate && $paymentDate <= $loanPaymentDetail->due_date)) {
            abort(Response::HTTP_BAD_REQUEST, trans('message.payment_date_incorrect'));
        }
        if ($request['amount'] < round($loanPaymentDetail->amount)) {
            abort(Response::HTTP_BAD_REQUEST, trans('message.amount_payment_invalid'));
        }
        
        $this->loanPaymentRep->update(['is_active' => ACTIVE], $loanPaymentDetail->id);
        $this->loanRep->update(['loan_status_id' => $loanStatus], $loanPaymentDetail->loan_id);
        
        $this->setMessage(trans('message.add_repayment_successfully'));
        
        return $this->getResponseData();
    }
}
