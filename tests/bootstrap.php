<?php

spl_autoload_register(function($class) {
    // Check if class or interface has been loaded allready
    if (class_exists($class, false) || interface_exists($class, false)) {
        return true;
    }
    
    $file = realpath(__DIR__.'/../src').'/'.str_replace('\\', '/', $class).'.php';
    
    // Include file if it exists
    if (file_exists($file)) {
        include($file);
        return true;
    }

    return false; 
});