<?php

if (!function_exists('curl_init')) {
    throw new Exception('CURL PHP extension is required');
}
if (!function_exists('json_decode')) {
    throw new Exception('JSON PHP extension is required');
}

function autoload($className)
{
    if (strpos($className, 'FasterPay') !== 0) {
        return;
    }
    $fileName = dirname(__DIR__) . '/lib/';
    if ($lastNsPos = strripos($className, '\\')) {
        $namespace = substr($className, 0, $lastNsPos);
        $className = substr($className, $lastNsPos + 1);
        $fileName  .= str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
    }
    $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
    if (is_file($fileName)) {
        require_once $fileName;
    }
}

spl_autoload_register('autoload');

