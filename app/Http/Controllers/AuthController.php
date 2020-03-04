<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Http\Requests\Auth\LoginRequest;
use App\Libraries\ApiResponse;

class AuthController extends BaseController
{
    use ApiResponse;
    
    protected $request;
    protected $authService;
    
    public function __construct(Request $request, AuthService $authServiceInstance)
    {
        parent::__construct($request);
        $this->authService = $authServiceInstance;
    }
    
    public function login()
    {
        $this->validate($this->request, LoginRequest::rules(), LoginRequest::messages());
        $data = $this->authService->login($this->request);
        
        return $this->sendResponse($data[RESPONSE_KEY], $data[STT_CODE_KEY]);
    }
    
    public function logout()
    {
        $data = $this->authService->logout();
        
        return $this->sendResponse($data[RESPONSE_KEY], $data[STT_CODE_KEY]);
    }
    
    public function getUserInfoByToken()
    {
        $data = $this->authService->getAuthenticatedUser();
        
        return $this->sendResponse($data[RESPONSE_KEY], $data[STT_CODE_KEY]);
    }
}
