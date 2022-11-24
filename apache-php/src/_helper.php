<?php
# MySQL Connection
function openmysqli(): mysqli {
    $connection = new mysqli('mysql', 'user', 'password', 'appDB');
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

# Start
function main()
{
    # Current URL
    $current_url = trim($_SERVER['REQUEST_URI'], '/');
    $current_url_array = explode('/', $current_url);

    # Redirect from root directory
    if (count($current_url_array) != 2) {
        header('Location: /home/home.php');
        return;
    }
    # Get classes by URL
    try {
        $ModelClass = getClass($current_url_array[0], 'Model');
        $ViewClass = getClass($current_url_array[0], 'View');
        $ControllerClass = getClass($current_url_array[0], 'Controller');
    } catch (Exception $e) {
        outputStatus(2, $e->getMessage());
        return;
    }
    # Start controller
    $ControllerClass = new $ControllerClass(
        $ModelClass,
        $ViewClass,
        '/' . $current_url
    );
    return $ControllerClass;
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
