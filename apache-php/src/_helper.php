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
