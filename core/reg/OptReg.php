<?php 
namespace erd\core\reg;
use erd\core\reg\StaticReg;

class OptReg extends StaticReg{
    //custom registry 
    protected static $arr = [];
    public function __construct(array $arr) {
        // Initialize the registry 
        self::$arr = $arr;
    }
    public static function has($key) {
        return isset(self::$arr[$key]);
    }
    public static function set($key, $value) {
        self::$arr[$key] = $value;
    }

    public static function get($key) {
        return self::$arr[$key] ?? null;
    }
}