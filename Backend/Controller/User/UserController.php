<?php 

namespace erd\Backend\Controller\User;
use erd\Backend\model\User;
use erd\core\render\Render;
class UserController{
    public static function index(){
        // $us = new User;
       $data = User::get();
       
      return Render::view("test",compact("data"));
    }
}