<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Http\{Request};
use Illuminate\Support\Facades\DB;

class UserService extends BaseService
{
    protected $userRep;
    
    public function __construct(UserRepository $userRep)
    {
        $this->userRep = $userRep;
    }
    
    public function getAll()
    {
        $this->setData($this->userRep->getAll());
        
        return $this->getResponseData();
    }
    
    public function getList(Request $request)
    {
        $this->setData($this->userRep->getList($request->all()));
        
        return $this->getResponseData();
    }
    
    public function create(Request $request)
    {
        DB::beginTransaction();
        
        $user = $this->userRep->create([
            "name"     => $request->get('name'),
            "email"    => $request->get('email'),
            "birthday" => $request->get('birthday'),
            "phone"    => $request->get('phone'),
            "address"  => $request->get('address')
        ]);
        
        DB::commit();
        
        $this->setMessage(trans('message.created_successfully'));
        $this->setData($user);
        
        return $this->getResponseData();
    }
    
}
