<?php

namespace Conductor;

/**
 * Loads the classes.
 * 
 * @author Cristian Hampus
 **/
class ClassLoader {
    /**
     * Register the class loader.
     */
    public static function register() {
        spl_autoload_register(array(__CLASS__, 'autoload'));
    }

    /**
     * Load classes if they don't exist yet.
     *
     * @param string $class
     */
    private static function autoload($class)
    {
        // Check if class or interface has been loaded allready
        if (class_exists($class, false) || interface_exists($class, false)) {
            return true;
        }
        
        $file = sprintf('%s/%s.php', realpath(__DIR__.'/..'), str_replace('\\', '/', $class));
        
        // Include file if it exists
        if (file_exists($file)) {
            include($file);
        }
    }
}
