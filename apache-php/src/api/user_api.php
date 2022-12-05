<?php
$cont = 'this'; // Ignore file warnings
// Mode
try {
    switch ($_SERVER['REQUEST_METHOD']) {
        // loginUser
        case 'POST':
            $login = $json["data"]["login"];
            $pass = $json["data"]["pass"];
            $result = $$cont->model->getAuthData($login);
            if ($result and $result[4] != 0) { // Check if result and user is not banned
                if (password_verify($pass, $result[1])) {
                    $_SESSION['fio'] = $result[0];
                    $_SESSION['login'] = $login;
                    $_SESSION['role'] = $result[2];
                    $_SESSION['id'] = $result[3];
                    $$cont->view->outputStatus(0, "Auth successful as " . $result[0]);
                    return;
                }
            }
            $$cont->view->outputStatus(1, "Wrong login or password");
            return;

        // exitLogin
        case 'DELETE':
            if ($json["deAuth"]) {
                if (!isset($_SESSION["role"])) {
                    $$cont->view->outputStatus(1, "Session not authorised");
                    return;
                }
                $preserve_theme = $_SESSION['theme'];
                session_destroy();
                session_start();
                $_SESSION['theme'] = $preserve_theme;
                $$cont->view->outputStatus(0, "DeAuth successful");
            }
            else {
                $$cont->view->outputStatus(1, "Wrong input");
            }
            return;

        // changeTheme
        case 'PATCH':
            if ($json["theme"]) {
                $theme = $_SESSION['theme'] ?? false;
                $_SESSION['theme'] = !$theme;
                $theme_str = !$theme ? 'true' : 'false';
                $$cont->view->outputStatus(0, "Theme toggle: " . $theme_str);
            } else {
                $$cont->view->outputStatus(1, "Wrong input");
            }
            return;

        // getOrderStatus
        case 'GET':
            $result = $$cont->model->getOrderStatus($_GET['order']);
            $$cont->view->outputStatus(0, $result[0], $result[1]);
            return;

        // Error
        default:
            $$cont->view->outputStatus(2, 'Invalid Mode');
    }
} catch (Exception $e) {
    $message = $e->getMessage();
    $$cont->view->outputStatus(2, $message);
}
?>