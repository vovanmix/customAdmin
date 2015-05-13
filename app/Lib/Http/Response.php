<?php

namespace Vovanmix\CustomAdmin\Lib\Http;

class Response{

    private $status = 200;
    private $headers;
    private $content;

    public function setStatus($status){
        $this->status = (int)$status;
    }

    public function setHeaders($headers){
        $this->headers = $headers;
    }

    public function setContent($content){
        $this->content = $content;
    }

    public function getStatus(){
        return $this->status;
    }

    public function getHeaders(){
        return $this->headers;
    }

    public function getContent(){
        return $this->content;
    }

    public function output(){

        http_response_code($this->getStatus());

        echo $this->getContent();
    }

}