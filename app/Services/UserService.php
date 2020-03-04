<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Http\{Response, Request};
use Illuminate\Support\Facades\DB;

class UserService extends BaseService
{
    protected $userRep;
    protected $rolesRep;
    protected $permissionRep;
    protected $userClientRep;
    
    public function __construct(UserRepository $userRep)
    {
        $this->userRep = $userRep;
    }
    
    public function getList(Request $request)
    {
        $data = $this->userRep->getList($request);
        $this->setData($data);
        
        return $this->getResponseData();
    }
    
    public function getDetail($id)
    {
        $data = $this->userRep->getDetail($id);
        $this->setData($data);
        
        return $this->getResponseData();
    }
    
    public function create(Request $request)
    {
        DB::beginTransaction();
        
        $user = $this->userRep->create([
            "username"   => $request->get('username'),
            "email"      => $request->get('email'),
            "password"   => app("hash")->make(trim($request->get('password'))),
            "first_name" => $request->get('first_name'),
            "last_name"  => $request->get('last_name'),
            "full_name"  => $request->get('full_name'),
            "birthday"   => $request->get('birthday'),
            "phone"      => $request->get('phone'),
            "address"    => $request->get('address'),
            'created_by' => $this->getCurrentUser('id')
        ]);
        
        DB::commit();
        
        $this->setMessage(trans('message.created_successfully'));
        $this->setData($user);
        
        return $this->getResponseData();
    }
    
    public function update(Request $request, $id)
    {
        $user = $this->userRep->find($id);
        if ($user) {
            $dataUpdate = $request->all();
            if (!empty($dataUpdate['password'])) {
                $dataUpdate['password'] = app("hash")->make(trim($request->get('password')));
            } else if (isset($dataUpdate['password'])) {
                unset($dataUpdate['password']);
            }
            
            DB::beginTransaction();
            
            $this->userRep->update($dataUpdate, $id);
            if (isset($request['roles_id']) && is_array($request['roles_id'])) {
                $roles = $request['roles_id'];
                if (empty($roles)) {
                    $user->detachRoles();
                } else {
                    $arrRoles = $this->rolesRep->findByMany($roles);
                    if ($arrRoles) {
                        // Renew roles before grant new roles
                        $user->detachRoles();
                        foreach ($arrRoles as $item) {
                            $user->roles()->attach($item['id']);
                        }
                    }
                }
            }
            
            // Grant Clients for user
            if (isset($request['client_ids']) && is_array($request['client_ids'])) {
                $arrClient = $this->userClientRep->findByMany($request['client_ids']);
                $this->userClientRep->deleteByConditions(['user_id' => $id]);
                $userClient = [];
                foreach ($arrClient as $row) {
                    $userClient[] = [
                        'user_id'   => $id,
                        'client_id' => $row->id,
                    ];
                }
                if (count($userClient)) {
                    $this->userClientRep->insertMultiple($userClient);
                }
            }
            
            
            DB::commit();
        }
        
        $user = $this->userRep->getDetail($id);
        
        $this->setMessage(trans('message.updated_successfully'));
        $this->setData($user);
        
        return $this->getResponseData();
    }
    
    
    public function delete($id)
    {
        $mgs     = trans('message.deleted_failed');
        $sttCode = Response::HTTP_SERVICE_UNAVAILABLE;
        
        if ($user = $this->userRep->getUserForDelete($id)) {
            $this->userRep->update(['is_delete' => 1], $user->id);
            $user->detachRoles(); // Revoke roles
            
            $sttCode = Response::HTTP_OK;
            $mgs     = trans('message.deleted_successfully');
        }
        
        $this->setStatusCode($sttCode);
        $this->setMessage($mgs);
        
        return $this->getResponseData();
    }
    
    public function updateStatus(Request $request, $id)
    {
        $user = $this->userRep->getDetail($id);
        if ($user) {
            $this->userRep->update([
                'is_active'  => empty($request['is_active']) ? STATUS_INACTIVE : STATUS_ACTIVE,
                'updated_by' => $this->getCurrentUser('id'),
            ], $id);
        }
        
        $this->setMessage($user ? 'Changed status successfully.' : 'Not Found data.');
        
        return $this->getResponseData();
    }
    
    public function activeClient($clientId)
    {
        $userId = $this->getCurrentUser('id');
        
        $data = $this->userRep->update(['client_id' => $clientId], $userId);
        
        $this->setData($data);
        $this->setMessage("Updated Successfully.");
        
        return $this->getResponseData();
    }
    
}
