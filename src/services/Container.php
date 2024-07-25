<?php

namespace App\Services;

class Container {
    private static $instances = [];

    public static function get($class) {
        if (!isset(self::$instances[$class])) {
            self::$instances[$class] = new $class();
        }
        return self::$instances[$class];
    }
}
?>
