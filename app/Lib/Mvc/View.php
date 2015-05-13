<?php

namespace Vovanmix\CustomAdmin\Lib\Mvc;

class View{

    private $layout = 'index';

    public function render($templatePath, $templateFile, $parameters=[]){

        $templateArray = [];
        if(!empty($templatePath)){
            $templateArray []= $templatePath;
        }
        if(!empty($templateFile)){
            $templateArray []= $templateFile;
        }

        $templateFullPath = APP . '/Views/' . implode('/', $templateArray).'.php';

        extract($parameters);

        ob_start();

        include($templateFullPath);

        $code = ob_get_contents();
        ob_end_clean();

        return $code;
    }

    public function renderLayout($code){
        return $this->render('Layout', $this->layout, ['content' => $code]);
    }

    public function setLayout($layout){
        $this->layout = $layout;
    }

}