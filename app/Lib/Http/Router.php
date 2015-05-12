<?php

namespace Vovanmix\CustomAdmin\Lib\Http;

class Router{

    /**
     * @param Request $request
     * @return Route
     */
    public function getRoute(Request $request){
        $uri = $request->getUri();
        if(!empty($uri)){
            $routeSchema = $this->parseUri($uri);
        }
        else{
            $routeSchema = [];
        }
        return new Route($routeSchema);
    }

    /**
     * @param string $uri
     * @return array
     */
    private function parseUri($uri){
        $routeSchema = [];
        $routeParameters = explode('/', trim($uri, '/'));
        if(!empty($routeParameters[0])) {
            $routeSchema['controller'] = $routeParameters[0];
        }
        if(!empty($routeParameters[1])) {
            $routeSchema['action'] = $routeParameters[1];
        }
        if(!empty($routeParameters[2])) {
            $routeSchema['id'] = $routeParameters[2];
        }
        return $routeSchema;
    }

}