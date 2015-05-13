<?php

namespace Vovanmix\CustomAdmin\Lib\Http;

class Request{

    private $get;
    private $post;
    private $files;
//    private $cookies;
    private $server;

    public function readSystemInput(){

        $this->get = filter_input_array(INPUT_GET);
        $this->post = filter_input_array(INPUT_POST);
        $this->files = $_FILES;
//        $this->cookies = filter_input_array(INPUT_COOKIE);
        $this->server = filter_input_array(INPUT_SERVER);
    }

    public function setInputGet($get){
        $this->get = $get;
    }
    public function setInputPost($post){
        $this->post = $post;
    }
    public function setInputServer($server){
        $this->server = $server;
    }

    /**
     * @return array
     */
    public function inputGetAll(){
        return $this->get;
    }

    /**
     * @return array
     */
    public function inputPostAll(){
        return $this->post;
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function inputGet($name){
        return isset($this->get[$name]) ? $this->get[$name] : NULL;
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function inputPost($name){
        return isset($this->post[$name]) ? $this->post[$name] : NULL;
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function inputFile($name){
        return isset($this->files[$name]) ? $this->files[$name] : NULL;
    }

    /**
     * @return array
     */
    public function getServerAll(){
        return $this->server;
    }

    /**
     * @param string $name
     * @return string
     */
    public function getServer($name){
        return isset($this->server[$name]) ? $this->server[$name] : NULL;
    }

    /**
     * @return string
     */
    public function getUri(){
        return $this->getServer('REQUEST_URI');
    }

}