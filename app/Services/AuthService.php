<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Facades\ActivityLogRepository;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Illuminate\Http\Request;

class AuthService extends BaseService
{
    protected $userRep;

    public function __construct(UserRepository $userRep)
    {
        $this->userRep = $userRep;
    }
    
    public function login(Request $request)
    {
        $field = filter_var($request->all(), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $credentials = [
            $field     => $request['account'],
            'password' => $request['password']
        ];
    
        if (!$token = JWTAuth::attempt($credentials, ['exp'=> 84600])) {
            $msg = 'Your account or password is incorrect';
            abort(Response::HTTP_BAD_REQUEST, $msg);
        }
    
        $auth = JWTAuth::user();
    
        if ($auth->is_active != STATUS_ACTIVE) {
            $msg = 'Your account is inactive. Please contact your system administrator';
            abort(Response::HTTP_UNAUTHORIZED, $msg);
        }
        
        ActivityLogRepository::writingAccessLog($request->all());
        
        $this->setMessage('Login successfully.');
        $this->setData([
            'token'     => $token,
            'user_info' => $auth,
        ]);
        
        return $this->getResponseData();
    }
    
    public function logout()
    {
        $token = JWTAuth::getToken();
        $params = [];
        
        try {
            $user = JWTAuth::user();
            $params = ['user_id' => $user ? $user->id : 0];
            
            JWTAuth::setToken($token)->invalidate();
        } catch (TokenInvalidException $ex) {
            abort( Response::HTTP_UNAUTHORIZED, 'Token is invalid');
        }
        ActivityLogRepository::writingAccessLog($params);
        
        $this->setMessage("Logged successfully");
        
        return $this->getResponseData();
    }
    
    public function getAuthenticatedUser()
    {
        $user = '';
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                abort(Response::HTTP_UNAUTHORIZED, 'Not Found User');
            }
        } catch (TokenExpiredException $ex) {
            abort(Response::HTTP_UNAUTHORIZED, 'Token expired');
        } catch (TokenInvalidException $ex) {
            abort( Response::HTTP_UNAUTHORIZED, 'Token is invalid');
        } catch (JWTException $ex) {
            abort( Response::HTTP_UNAUTHORIZED, 'Token absent');
        }
        
        $user->roles;
        $this->setData($user);
        
        return $this->getResponseData();
    }
    
    public function create()
    {
        $dataCreate = [
            [
                'is_master'         => 0,
                'roles_id'          => 7,
                'username'          => 'phd-internal',
                'email'             => 'phd-internal@gmail.com',
                'password'          => app('hash')->make('phd1234@'),
                'original_password' => 'phd1234@',
                'first_name'        => 'PHD',
                'last_name'         => 'Internal',
                'full_name'         => 'PHD Internal',
                'birthday'          => '1995-01-01',
                'phone'             => '012345678',
                'address'           => 'Jakata',
            ]
        ];
        foreach ($dataCreate as $data) {
            
            $this->userRep->create($data);
        }
    }
}
