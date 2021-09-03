<?php
@header('Access-Control-Allow-Origin: *');
@ini_set('display_errors', true);
@error_reporting(E_ALL);
@setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
@date_default_timezone_set('America/Sao_Paulo');

function autoload($className)
{
    $found = false;
    $classpaths = [
        'class' . DIRECTORY_SEPARATOR,
        'controller' . DIRECTORY_SEPARATOR,
        'helpers' . DIRECTORY_SEPARATOR,
        'lib' . DIRECTORY_SEPARATOR,
        'model' . DIRECTORY_SEPARATOR,
    ];
    foreach ($classpaths as $path) {
        $className = str_replace('\\', '/', $className);
        if (preg_match('/Model/', $className)) {
            $class = "$className.php";
        } else {
            $class = ucfirst("$className.php");
        }
        if (preg_match('/\//', $class)) {
            $names = explode("/", $className);
            if (isset($names[1])) {
                $class = $names[1];
                $path = $path . $names[0] . DIRECTORY_SEPARATOR;
                $filepath = __DIR__ . DIRECTORY_SEPARATOR . $path . $class . ".php";
            } else {
                (new Page)->error('Página não encontrada');
            }
        } else {
            $filepath = __DIR__ . DIRECTORY_SEPARATOR . $path . $class;
        }
        if (is_readable("$filepath")) {
            $found = true;
            require_once "$filepath";
            break;
        }
    }
    if (!$found) {
        (new Page)->error('Página não encontrada');
    }
}
spl_autoload_register('autoload');
require_once 'core' . DIRECTORY_SEPARATOR . 'getroute.php';
require_once 'core' . DIRECTORY_SEPARATOR . 'registry.php';
