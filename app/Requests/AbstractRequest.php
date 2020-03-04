<?php

namespace App\Http\Requests;

interface AbstractRequest
{

    /**
     * @return array
     */
     public static function rules();

    /**
     * @return array
     */
    public static function messages();
}
