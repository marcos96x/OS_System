<?php

require_once "config/routes.php";

if (isset($routes["$Controller"])) {
    $parts = explode(":", $routes["$Controller"]);
    $Controller = $parts[0];
    $Action = $parts[1];
}
$Controller = preg_replace("/[^a-zA-Z0-9]+/", '', $Controller);
if(class_exists($Controller)) {
    $obj = new $Controller;
    
    $obj->baseurl = Http::base();
    if (method_exists($Controller, $Action)) {
        $obj->$Action();
    } else {
        if (!in_array($Controller, $ignore) && !in_array($Action, $ignore)) {
            (new Page)->error("$Controller::$Action() - Método não encontrado");
        } else {
            $obj->indexAction();
        }
    }
} else {
    (new Page)->error("Método não encontrado");
}
