<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;
use App\Libraries\ApiResponse;


class BaseController extends Controller
{
    use ApiResponse;
    
    /**
     * Object request
     *
     * @var Request
     */
    protected $request;
    
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
}
