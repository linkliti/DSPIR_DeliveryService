<?php
// Mode
try {
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'POST':
            loginUser($json);
            break;
        case 'DELETE':
            exitLogin();
            break;
        case 'PATCH':
            changeTheme();
            break;
        case 'GET':
            getOrderStatus($json);
            break;
        default:
            outputStatus(2, 'Invalid Mode');
    }
} catch (Exception $e) {
    $message = $e->getMessage();
    outputStatus(2, $message);
}

function loginUser($json) {
}

function exitLogin() {
    $preserve_theme = $_SESSION['theme'];
    session_destroy();
    session_start();
    $_SESSION['theme'] = $preserve_theme;
    header("location: /home/home.php");
}

function changeTheme()
{
    $theme = $_SESSION['theme'] ?? false;
    $_SESSION['theme'] = !$theme;
}
function getOrderStatus($json)
{
    $controller = '$this'; // ignore errors
    $$controller->model->getOrderStatus();
}
?>