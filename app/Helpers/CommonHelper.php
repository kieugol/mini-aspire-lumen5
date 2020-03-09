<?php

namespace App\Helpers;

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
}
