<?php
# MySQL Connection
function openmysqli(): mysqli {
    $connection = new mysqli('mysql', 'user', 'password', 'DeliveryService');
    return $connection;
}

# File from root directory
function getFileFromRoot($path) {
    return $_SERVER['DOCUMENT_ROOT'] . $path;
}

// Wrap in commas
function wrap($o) {
    if (is_array($o)) {
        foreach ($o as $i => $e) {
            $o[$i] = '"' . $e . '"';
        }
        return implode(', ', $o);
    }
    else if (is_string($o)) {
        return '"' . $o . '"';
    }
}

function currentFile() {
    $s = (explode('/', $_SERVER['REQUEST_URI']))[2];
    return strstr($s, '?', true) ?: $s;
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
