<?php

namespace App\Services;

use Illuminate\Http\Response;
use App\Helpers\CommonHelper;

class BaseService
{
    use CommonHelper;
    
    /**
     * The data return on response
     *
     * @var string
     */
    private $data = '';
    
    /**
     * The message on response
     *
     * @var string
     */
    private $message = '';
    
    /**
     * The code on response for handle some special case
     *
     * @var string
     */
    private $code = Response::HTTP_OK;
    
    /**
     * Status code for header
     *
     * @var int
     */
    private $statusCode = Response::HTTP_OK;
    
    /**
     * Set status code for header
     *
     * @param $statusCode
     */
    protected function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
    }
    
    /**
     * Get Status code
     *
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }
    
    /**
     * Set data for response
     *
     * @param mixed $data
     */
    protected function setData($data)
    {
        $this->data = $data;
    }
    
    /**
     * Get data on response
     *
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }
    
    /**
     * Set the message for response
     *
     * @param string $mgs
     */
    protected function setMessage($mgs = '')
    {
        $this->message = $mgs;
    }
    
    /**
     * Get the message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }
    
    /**
     * Set code for response
     *
     * @param $code
     */
    protected function setCode($code)
    {
        $this->code = $code;
    }
    
    /**
     * Get the code
     *
     * @return integer
     */
    public function getCode()
    {
        return $this->code;
    }
    
    /**
     * get All data of rest full api
     *
     * @return array
     */
    protected function getResponseData()
    {
        return [
            RESPONSE_KEY => [
                CODE_KEY    => $this->code,
                DATA_KEY    => $this->data,
                MESSAGE_KEY => $this->message,
            ],
            STT_CODE_KEY => $this->getStatusCode()
        ];
    }
}
