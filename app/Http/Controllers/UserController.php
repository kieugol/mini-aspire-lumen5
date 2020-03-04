<?php

namespace App\Http\Controllers;
use App\Http\Validators\User\UserCreateValidator;
use App\Http\Validators\User\UserUpdateValidator;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Libraries\Api;

class UserController extends Controller
{
    protected $request;
    protected $userService;

    public function __construct(Request $request, UserService $userServiceInstance)
    {
        $this->request = $request;
        $this->userService = $userServiceInstance;
    }
    
    public function getList()
    {
        $result = $this->userService->getList($this->request);
        
        return Api::response($result[RESPONSE_KEY], $result[STT_CODE_KEY]);
    }
    
    public function getDetail($id)
    {
        $result = $this->userService->getDetail($id);
        
        return Api::response($result[RESPONSE_KEY], $result[STT_CODE_KEY]);
    }
    
    public function create()
    {
        $this->validate($this->request, UserCreateValidator::rules(), UserCreateValidator::messages());
        
        $result = $this->userService->create($this->request);
        
        return Api::response($result[RESPONSE_KEY], $result[STT_CODE_KEY]);
    }
    
    public function update($id)
    {
        $this->request->merge(['id' => $id]);
        
        $this->validate($this->request, UserUpdateValidator::rules(), UserUpdateValidator::messages());
        
        $result = $this->userService->update($this->request, $id);
        
        return Api::response($result[RESPONSE_KEY], $result[STT_CODE_KEY]);
    }
    
    public function delete($id)
    {
        $result = $this->userService->delete($id);
        
        return Api::response($result[RESPONSE_KEY], $result[STT_CODE_KEY]);
    }
    
    public function updateStatus($id)
    {
        $data = $this->userService->updateStatus($this->request, $id);
        
        return Api::response($data[RESPONSE_KEY], $data[STT_CODE_KEY]);
    }
    
    public function activeClient($clientId)
    {
        $result = $this->userService->activeClient($clientId);
        
        return Api::response($result[RESPONSE_KEY], $result[STT_CODE_KEY]);
    }
}
