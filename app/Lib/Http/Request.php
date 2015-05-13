<?php

namespace Vovanmix\CustomAdmin\Lib\Http;

class Request{

    private $get;
    private $post;
    private $files;
//    private $cookies;
    private $server;
    private $session;

    public function readSystemInput(){

        $this->get = filter_input_array(INPUT_GET);
        $this->post = filter_input_array(INPUT_POST);
        $this->files = $_FILES;
//        $this->cookies = filter_input_array(INPUT_COOKIE);
        $this->server = filter_input_array(INPUT_SERVER);
        $this->session = $_SESSION;
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
        if(isset($this->files[$name])){
            $files = $this->convertFilesArray($name);
            if(count($files) == 1){
                return reset($files);
            }
            else{
                return $files;
            }
        }
        else{
            return NULL;
        }
    }

    /**
     * @param string $name
     * @return array
     */
    private function convertFilesArray($name){
        $files = [];
        foreach($this->files[$name]['name'] as $fileIndex => $fileName){
            $files[] = [
                'name' => $this->files[$name]['name'][$fileIndex],
                'type' => $this->files[$name]['type'][$fileIndex],
                'tmp_name' => $this->files[$name]['tmp_name'][$fileIndex],
                'error' => $this->files[$name]['error'][$fileIndex],
                'size' => $this->files[$name]['size'][$fileIndex],
            ];
        }
        return $files;
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
     * @param string $name
     * @return string
     */
    public function getSession($name){
        return isset($this->session[$name]) ? $this->session[$name] : NULL;
    }

    /**
     * @param string $name
     * @param string $val
     * @return mixed
     */
    public function setSession($name, $val){
        $this->session[$name] = $_SESSION[$name] = $val;
    }

    /**
     * @return string
     */
    public function getUri(){
        return $this->getServer('REQUEST_URI');
    }

}