<?php
# Start session
session_start();
if (!isset($_SESSION["theme"]) ||
    !isset($_SESSION["views"]) ||
    !isset($_SESSION["login"]))
{
    $_SESSION["theme"] = 0;
    $_SESSION["views"] = 0;
    $_SESSION["login"] = ' ';
}

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
