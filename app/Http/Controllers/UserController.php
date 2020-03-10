<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UserCreateRequest;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    protected $userService;
    
    public function __construct(Request $request, UserService $userServiceInstance)
    {
        parent::__construct($request);
        
        $this->userService = $userServiceInstance;
    }
    
    public function getList()
    {
        $result = $this->userService->getList($this->request);
        
        return $this->sendResponse($result[RESPONSE_KEY], $result[STT_CODE_KEY]);
    }
    
    public function create()
    {
        $this->validate($this->request, UserCreateRequest::rules(), UserCreateRequest::messages());
        
        $result = $this->userService->create($this->request);
        
        return $this->sendResponse($result[RESPONSE_KEY], $result[STT_CODE_KEY]);
    }
}
