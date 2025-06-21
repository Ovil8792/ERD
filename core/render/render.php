<?php 

namespace erd\core\render;

class Render{
    public static function view($viewname, $data = []){
        $viewPath = dirname(__DIR__,2) . "/Frontend/view/{$viewname}.php";
        if(file_exists($viewPath)){
            extract($data);
            ob_start();
            include $viewPath;
            return ob_get_clean();
        } else {
            throw new \Exception("File View không tồn tại: {$viewname}");
        }
    }
}