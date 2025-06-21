<?php

namespace erd\core\routing;
use erd\core\reg\OptReg;

class RouteControl
{
    public static function dispatch(){
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        $key = "$method:$uri";
        // var_dump(OptReg::has($key));
        if (OptReg::has($key)) {
            $callback = OptReg::get($key);
            echo call_user_func($callback);
        } else {
            http_response_code(404);
            echo "404 Not Found - Route không tồn tại.";
        }
    }
    protected $routes = [];
    public function __construct($routes = [])
    {
        $this->routes = $routes;
    }
    public function Routing()
    {
        $requested_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $basepath = "";
        $routepath = "/" . trim(str_replace($basepath, "", $requested_uri), "/");
        $routepath = $routepath === "/" ? "/" : "/$routepath";
        if (isset($this->routes[$routepath])) {
            $this->routes[$routepath]();
            $reg = new OptReg(self::$routes);
            $reg->set('route', $routepath);
        } else {
            http_response_code(404);
            echo "404 Not Found";
        }

    }
    public static function get(string $path, callable $callback){
        OptReg::set("GET:$path",$callback);
    }
    public static function post(string $path, callable $callback){
        OptReg::set("POST:$path",$callback);
    }
    public static function put(){
        
    }
    public static function delete(){
        
    }



}
// echo 1;