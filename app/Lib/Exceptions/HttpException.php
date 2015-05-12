<?php

namespace Vovanmix\CustomAdmin\Lib\Exceptions;

use Exception;

class HttpException extends Exception{
    protected $message = 'Exception';
    protected $statusCode = 404;

    public function getStatusCode(){
        return $this->statusCode;
    }

}