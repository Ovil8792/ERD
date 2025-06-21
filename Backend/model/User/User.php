<?php

namespace erd\Backend\model;
use  erd\core\model\connector;
use erd\core\model\db;
class User extends connector{
    protected static $db;
    public static function get(){
        self::$db = new db("user");
        return self::$db->get();
    }
}