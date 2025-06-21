<?php
// namespace erd;
namespace erd\core\reg;
class Registry {
    //view registry
    private static $store = [];

    public static function set($key, $value) {
        self::$store[$key] = $value;
    }

    public static function get($key) {
        return self::$store[$key] ?? null;
    }
}
