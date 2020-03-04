<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;

class BaseController extends Controller
{
    /**
     * @var
     */
    protected $request;
    
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
}
