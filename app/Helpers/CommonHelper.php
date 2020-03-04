<?php

namespace App\Helpers;

use Tymon\JWTAuth\Facades\JWTAuth;

trait CommonHelper
{
    
    /**
     * Format validation error message
     *
     * @param array $errors
     *
     * @return null|string
     */
    public function formatErrorsMessage(array $errors)
    {
        $errMgs = [];
        
        foreach ($errors as $key => $error) {
            $errMgs = array_merge($errMgs, $error);
        }
        
        $errMgs = array_values(array_unique($errMgs));
        
        if (!$errMgs) {
            return null;
        }
        
        return implode('<br>', $errMgs);
    }
    
    /**
     * Get user information with key
     *
     * @param string $key
     *
     * @return null
     */
    public function getAuth($key = '')
    {
        try {
            $user = JWTAuth::user();
            return $key != '' ? (empty($user->{$key}) ? null : $user->{$key}) : $user;
        } catch (\Exception $ex) {
            return null;
        }
    }
}
