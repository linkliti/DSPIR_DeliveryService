<?php
// On start
session_start();
date_default_timezone_set("Europe/Moscow");
require_once $_SERVER['DOCUMENT_ROOT'] . '/_helper.php';
main();

function main()
{
    # Current URL
    $current_url = explode('/', trim($_SERVER['REQUEST_URI'], '/'));

    # Redirect from root directory
    if (count($current_url) != 2) {
        header('Location: /home/home.php');
        return;
    }
    # Start classes
    try {
        $ModelClass = getClass($current_url[0], 'Model');
        $ViewClass = getClass($current_url[0], 'View');
        $ControllerClass = getClass($current_url[0], 'Controller');
    } catch (Exception $e) {
        outputStatus(2, $e->getMessage());
        return;
    }
    $ControllerClass = new $ControllerClass($ModelClass, $ViewClass);
}


# Get class
function getClass($path, $classtype)
{
    $classpath = getFileFromRoot("/{$path}/_{$classtype}.php"); // Задание пути к контроллеру
    $class = "{$path}{$classtype}"; // Задание пути к классу контроллера
    if (file_exists($classpath)) {
        require_once $classpath;
        if (class_exists($class))
            return $class;
    }
    throw new Exception('Missing Class');
}