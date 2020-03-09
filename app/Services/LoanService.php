<?php

namespace App\Services;

use App\Repositories\{LoanRepository, LoanPaymentRepository};
use Illuminate\Http\{Request};
use Illuminate\Support\Facades\DB;

class LoanService extends BaseService
{
    protected $loanRep;
    protected $loanPaymentRep;
    
    public function __construct(LoanRepository $loanRep, LoanPaymentRepository $loanPaymentRep)
    {
        $this->loanRep        = $loanRep;
        $this->loanPaymentRep = $loanPaymentRep;
    }
    
    public function getAll()
    {
        $this->setData($this->loanRep->getAll());
        
        return $this->getResponseData();
    }
    
    public function getList(Request $request)
    {
        $this->setData($this->loanRep->getList($request->all()));
        
        return $this->getResponseData();
    }
    
    public function getListByUserId($userId)
    {
        $this->setData($this->loanRep->getListByUserId($userId));
        
        return $this->getResponseData();
    }
    
    public function getDetail($id)
    {
        $this->setData($this->loanRep->find($id));
        
        return $this->getResponseData();
    }
    
    /**
     * Create loan and loan payment for each month
     *
     * @param Request $request
     *
     * @return array
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function create(Request $request)
    {
        DB::beginTransaction();
        
        $months = MONTHS_OF_YEAR * $request['loan_term'];
        
        $newLoan = $this->loanRep->create([
            'user_id'                => $request['user'],
            'loan_status_id'         => LOAN_STATUS_NEW,
            'start_date'             => date("Y-m-d"),
            'end_date'               => date('Y-m-d', strtotime("+$months months")),
            'repayment_frequency_id' => $request['repayment_frequency'],
            'term'                   => $request['loan_term'],
            'interest_rate'          => $request['interest_rate'],
            'amount'                 => $request['amount']
        ]);
        
        // Handle creating loan payment
        $numberPayment      = $months;
        $interestEachPeriod = number_format($newLoan->interest_rate / $newLoan->repayment_frequency->value, 2, '.', '');
        $firstDebt          = $newLoan->amount;
        $principalAmount    = number_format($firstDebt / $numberPayment, 2, '.', '');
        $dueDate            = date('Y-m-t', strtotime($newLoan->start_date));
        $totalInterest      = 0;
        $totalPayment       = 0;
        $loanPayment        = [];
        
        for ($i = 1; $i <= $numberPayment; $i++) {
            $interestAmount = number_format(($interestEachPeriod * $firstDebt) / 100, 2, '.', '');
            $paymentAmount  = number_format($principalAmount + $interestAmount, 2, '.', '');
            $balance        = $i == $numberPayment ? 0 : number_format($firstDebt - $principalAmount, 2, '.', ''); // Final period then balance = 0
            
            $loanPayment[] = [
                'loan_id'          => $newLoan->id,
                'due_date'         => $dueDate,
                'principal_amount' => $principalAmount,
                'interest_amount'  => $interestAmount,
                'amount'           => $paymentAmount,
                'balance'          => $balance,
            ];
            
            $firstDebt     = $balance;
            $totalInterest += $interestAmount;
            $totalPayment  += $paymentAmount;
            $dueDate       = date('Y-m-t', strtotime("+4 days", strtotime($dueDate))); // plus 4 days to go next month
        }
        $this->loanPaymentRep->insertMultiple($loanPayment);
        // Update total payment and total interest need to pay for a loan
        $this->loanRep->update(['payment_amount' => round($totalPayment), 'interest_amount' => round($totalInterest)], $newLoan->id);
        
        DB::commit();
        
        $this->setMessage(trans('message.created_successfully'));
        $this->setData(['id' => $newLoan->id]);
        
        return $this->getResponseData();
    }
    
}
