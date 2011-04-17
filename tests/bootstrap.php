<?php

spl_autoload_register(function($class) {
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
});