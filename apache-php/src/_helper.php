<?php
# MySQL Connection
function openmysqli(): mysqli {
    $connection = new mysqli('mysql', 'user', 'password', 'DeliveryService');
    return $connection;
}

# JSON Status output
function outputStatus($status, $message)
{
    echo '{status: ' . $status . ', message: "' . $message . '"}';
}

# File from root directory
function getFileFromRoot($path) {
    return $_SERVER['DOCUMENT_ROOT'] . $path;
}

function currentFile() {
    return (explode('/', $_SERVER['REQUEST_URI']))[2];
}
# Get class
function getClass($path, $classtype)
{
    $classpath = getFileFromRoot("/{$path}/_MVC.php"); // Задание пути к контроллеру
    $class = "{$path}{$classtype}"; // Задание пути к классу контроллера
    if (file_exists($classpath)) {
        require_once $classpath;
        if (class_exists($class))
            return $class;
    }
    throw new Exception('Missing Class');
}
