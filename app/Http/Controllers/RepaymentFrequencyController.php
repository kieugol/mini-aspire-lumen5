<?php

namespace App\Http\Controllers;

use App\Services\RepaymentFrequencyService;
use Illuminate\Http\Request;

class RepaymentFrequencyController extends BaseController
{
    protected $repaymentFrequencyService;
    
    public function __construct(Request $request, RepaymentFrequencyService $repaymentFrequencyInstance)
    {
        parent::__construct($request);
        
        $this->repaymentFrequencyService = $repaymentFrequencyInstance;
    }
    
    public function getAll()
    {
        $result = $this->repaymentFrequencyService->getAll();
        
        return $this->sendResponse($result[RESPONSE_KEY], $result[STT_CODE_KEY]);
        
    }
}
