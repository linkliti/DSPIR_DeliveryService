<head>
  <title>Session Debug Page</title>
</head>

<?php
if (!checkPrivilege('admin')) {
    require_once getFileFromRoot('/table/utils/_access_denied_msg.php');
    return;
}
?>

<div class="container mt-4">
  <h1>Session Debug Page</h1>
  <?php
        if (!isset($_SESSION['views'])) {
          $_SESSION['views'] = 0;
        }
        $_SESSION['views']++;
        $current_theme = $_SESSION['theme'] ? 'black' : 'white';
        $current_fio = isset($_SESSION['fio']) ? $_SESSION['fio'] : 'Not set';
        $current_login = isset($_SESSION['login']) ? $_SESSION['login'] : 'Not set';
        $current_role = isset($_SESSION['role']) ? $_SESSION['role'] : 'Not set';
        $current_id = isset($_SESSION['id']) ? $_SESSION['id'] : 'Not set';
        $current_theme = $_SESSION['theme'] ? 'black' : 'white';
        echo "Your session ID: " . session_id() . "<br>";
        echo "You have visited this page: {$_SESSION['views']} times<br>";
        echo "Last color theme: {$current_theme}<br>";
        echo "FIO: {$current_fio}<br>";
        echo "Worker ID: {$current_id}<br>";
        echo "Login: {$current_login}<br>";
        echo "Role: {$current_role}<br>";
        ?>
  <br><a href="/home/home.php">На главную</a>
</div>