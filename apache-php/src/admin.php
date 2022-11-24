<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/_helper.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/session/html_header.php';
?>
<html lang="ru">

<head>
    <title>Админ панель</title>
</head>

<body>
    <div id="wblock">
        <h1>Список пользователей</h1>
        <?php
        require_once '_helper.php';
        $mysqli = openmysqli();
        $users = $mysqli->query('select * from ' . 'users');
        ?>
        <table cellspacing="0" , style="width:100%">
            <tr>
                <th>Номер</th>
                <th>Логин</th>
                <th>Хеш пароля</th>
            </tr>
            <?php foreach ($users as $user) {
                echo "
            <tr>
                <td>{$user['ID']}</td>
                <td>{$user['name']}</td>
                <td>{$user['password']}</td>
            </tr>
            ";
            }; ?>
        </table>
        <br><a href="/index.php">На главную</a>
        <div>
            <?php $mysqli->close(); ?>
</body>

</html>