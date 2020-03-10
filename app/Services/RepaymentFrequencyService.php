<?php

namespace App\Services;

use App\Repositories\RepaymentFrequencyRepository;

class RepaymentFrequencyService extends BaseService
{
    protected $repaymentFrequencyRep;
    
    public function __construct(RepaymentFrequencyRepository $repaymentFrequencyRep)
    {
        $this->repaymentFrequencyRep = $repaymentFrequencyRep;
    }
    
    public function getAll()
    {
        $this->setData($this->repaymentFrequencyRep->getAll());
        
        return $this->getResponseData();
    }
}
