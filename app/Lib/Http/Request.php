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

    function setInputGet($get){
        $this->get = $get;
    }
    function setInputPost($post){
        $this->post = $post;
    }
    function setInputServer($server){
        $this->server = $server;
    }

    /**
     * @return array
     */
    function inputGetAll(){
        return $this->get;
    }

    /**
     * @return array
     */
    function inputPostAll(){
        return $this->post;
    }

    /**
     * @param string $name
     * @return mixed
     */
    function inputGet($name){
        return isset($this->get[$name]) ? $this->get[$name] : NULL;
    }

    /**
     * @param string $name
     * @return mixed
     */
    function inputPost($name){
        return isset($this->post[$name]) ? $this->post[$name] : NULL;
    }

    /**
     * @param string $name
     * @return mixed
     */
    function inputFile($name){
        return isset($this->files[$name]) ? $this->files[$name] : NULL;
    }

    /**
     * @return array
     */
    function getServerAll(){
        return $this->server;
    }

    /**
     * @param string $name
     * @return string
     */
    function getServer($name){
        return isset($this->server[$name]) ? $this->server[$name] : NULL;
    }

    /**
     * @return string
     */
    function getUri(){
        return $this->getServer('REQUEST_URI');
    }

}