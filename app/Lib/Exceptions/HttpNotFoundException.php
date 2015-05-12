<?php

namespace Vovanmix\CustomAdmin\Lib\Exceptions;

class HttpNotFoundException extends HttpException{
    protected $message = 'This page was not found';
    protected $statusCode = 404;
}