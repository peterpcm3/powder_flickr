<?php


spl_autoload_register(function ($class) {

    $prefix     = 'App\\';
    $lib_prefix = 'Lib\\';
    $base_dir   = __DIR__ . '/';
    
    $len        = strlen($prefix);
    $lib_len    = strlen($lib_prefix);
    if(strncmp($prefix, $class, $len) !== 0)
    {
        if(strncmp($lib_prefix, $class, $lib_len) !== 0)
        {
            return ;
        }
    }
    
    $file       = $base_dir . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file))
    {
        require $file;
    }
});