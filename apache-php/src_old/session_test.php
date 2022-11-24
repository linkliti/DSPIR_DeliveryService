<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/controller/_helper.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/view/html_header.php';
?>
<html lang="en">

<head>
    <title>Session Debug Page</title>
</head>

<body>
    <div id="wblock">
        <h1>Session Debug Page</h1>
        <?php
        $_SESSION['views']++;
        $current_theme = $_SESSION['theme'] ? 'black' : 'white';
        echo "Your session ID: " . session_id() . "<br>";
        echo "You have visited this page: {$_SESSION['views']} times<br>";
        echo "Last set color Theme: {$current_theme}<br>";
        ?>
        <br><a href="/index.php">На главную</a>
    </div>
</body>

</html>