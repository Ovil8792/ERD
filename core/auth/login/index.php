<?php

namespace erd\auth\login;
use erd\core\reg\Registry;
use erd\render\Render;
class Login{
    protected $admin = false;
    public function login(){
        $usn = $_POST['username'] ?? '';
        $pwd = $_POST['password'] ?? '';
        if($usn === 'admin' && $pwd === 'password'){
            $_SESSION['auth'] = [$usn, $pwd];
            Registry::set($this->admin , true);
            return Render::view("main");
        }
    }
    public function checkAdmin(){

    }
    public function getData(){

    }
}