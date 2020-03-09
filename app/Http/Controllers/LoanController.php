<?php

namespace App\Http\Controllers;

use App\Http\Requests\Loan\{LoanCreateRequest};
use App\Services\LoanService;
use Illuminate\Http\Request;

class LoanController extends BaseController
{
    protected $loanService;
    
    public function __construct(Request $request, LoanService $loanService)
    {
        parent::__construct($request);
        
        $this->loanService = $loanService;
    }
    
    public function getList(Request $request)
    {
        $result = $this->loanService->getList($request);
        
        return $this->sendResponse($result[RESPONSE_KEY], $result[STT_CODE_KEY]);
    }
    
    public function getListByUser($userId)
    {
        $result = $this->loanService->getListByUserId($userId);
        
        return $this->sendResponse($result[RESPONSE_KEY], $result[STT_CODE_KEY]);
    }
    
    public function getDetail($id)
    {
        $result = $this->loanService->getDetail($id);
        
        return $this->sendResponse($result[RESPONSE_KEY], $result[STT_CODE_KEY]);
    }
    
    public function create()
    {
        $this->validate($this->request, LoanCreateRequest::rules(), LoanCreateRequest::messages());
        
        $result = $this->loanService->create($this->request);
        
        return $this->sendResponse($result[RESPONSE_KEY], $result[STT_CODE_KEY]);
    }
}
