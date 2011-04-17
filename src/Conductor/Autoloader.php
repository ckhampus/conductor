<?php

namespace Conductor;

/**
 * Loads the classes.
 * 
 * @author Cristian Hampus
 **/
class Autoloader 
{
    /**
     * Register the class loader.
     *
     * @return void
     */
    public static function register() 
    {
        $loader = new Autoloader;
        
        spl_autoload_register(array($loader, 'autoload'));
    }

    /**
     * Load classes if they don't exist yet.
     *
     * @param string $class
     * @return bool
     */
    private function autoload($class)
    {
        // Check if class or interface has been loaded allready
        if (class_exists($class, false) || interface_exists($class, false)) {
            return true;
        }
        
        $file = sprintf('%s/%s.php', realpath(__DIR__.'/..'), str_replace('\\', '/', $class));
        
        // Include file if it exists
        if (file_exists($file)) {
            include($file);
            return true;
        }

        return false;
    }
}
