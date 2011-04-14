<?php

namespace Conductor;

/**
 * ClassLoader
 **/
class ClassLoader {
    
    public static function register() {
        spl_autoload_register(array(__CLASS__, 'autoload'));
    }

    private static function autoload($class)
    {
        if (class_exists($class, false) || interface_exists($class, false)) {
            return true;
        }

        $path = realpath(__DIR__.'/..');

        $class = str_replace('\\', '/', $class);

        $file = sprintf('%s/%s.php', $path, $class);

        if (file_exists($file)) {
            include($file);
        }
    }
}
