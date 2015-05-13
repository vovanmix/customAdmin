<?php

namespace Vovanmix\CustomAdmin\Lib\Exceptions;

class ModelException extends HttpException{
    protected $message = 'ModelException';
    protected $statusCode = 500;

}