<?php

namespace App\Http\Requests\User;

use App\Http\Requests\AbstractRequest;

class UserCreateRequest implements AbstractRequest
{
    public static function rules()
    {
        return [
            'email'    => 'required|unique:user,email',
            'name'     => 'required|min:6|max:50',
            'birthday' => 'required|date',
            'phone'    => 'required|min:10|max:15|unique:user,phone',
            'address'  => 'required|min:6|max:200',
        ];
    }
    
    /**
     * @return array
     */
    public static function messages()
    {
        return [];
    }
}
