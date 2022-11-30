<?php
$cont = 'this'; // Ignore file warnings
// Mode
try {
    switch ($_SERVER['REQUEST_METHOD']) {
        // loginUser
        case 'POST':
            break;

        // exitLogin
        case 'DELETE':
            $preserve_theme = $_SESSION['theme'];
            session_destroy();
            session_start();
            $_SESSION['theme'] = $preserve_theme;
            header("location: /home/home.php");
            break;

        // changeTheme
        case 'PATCH':
            $theme = $_SESSION['theme'] ?? false;
            $_SESSION['theme'] = !$theme;
            break;

        // getOrderStatus
        case 'GET':
            $result = $$cont->model->getOrderStatus($_GET['order']);
            $$cont->view->outputStatus(0, $result[0], $result[1]);
            break;

        // Error
        default:
            $$cont->view->outputStatus(2, 'Invalid Mode');
    }
} catch (Exception $e) {
    $message = $e->getMessage();
    $$cont->view->outputStatus(2, $message);
}
?>