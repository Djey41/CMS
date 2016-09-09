<?php
 declare (strict_types=1);// PHP 7 type hinting
require_once (__DIR__ . '/application/models/functions.php');
define ('LOG_PATH', __DIR__.'\logs\errors_log.txt');

/**
 *  @string $class_name - getting namespase
 * @param $class_name
 */
function my_autoloader($class_name) {
    //$class_name = strtolower($class_name);
    $path = __DIR__."\\application\\{$class_name}.php";
    if (file_exists($path))
    {
        require_once ($path);
    }
}

spl_autoload_register('my_autoloader');
