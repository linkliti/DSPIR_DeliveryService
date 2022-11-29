<?php
// On start
session_start();
date_default_timezone_set("Europe/Moscow");
require_once $_SERVER['DOCUMENT_ROOT'] . '/_helper.php';
$ControllerClass = main();

# Start
function main()
{
    # Redirect on missing files
    $server_path = $_SERVER["DOCUMENT_ROOT"] . $_SERVER["REQUEST_URI"];
    if (!(file_exists($server_path))) {
        header("location: /error.html");
        return;
    };
    # Server misc in userContent
    $current_url = trim($_SERVER['REQUEST_URI'], '/');
    $current_url_array = explode('/', $current_url);
    if ($current_url_array[0] == 'userContent') {
        require_once getFileFromRoot('/'. $current_url);
        return;
    }
    # Test MySQL server
    try {
        openmysqli();
    }
    catch (Exception $e) {
        echo 'Service not available. Please try again later.';
        return;
    }
    # Current URL

    # Redirect from root directory
    if (count($current_url_array) == 1) {
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