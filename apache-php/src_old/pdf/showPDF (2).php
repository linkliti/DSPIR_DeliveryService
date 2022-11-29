<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/_helper.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/session/html_header.php';
?>
<html>

<head>
    <title>PDF файлы</title>
</head>

<body>
    <div id="wblock">
        <form enctype="multipart/form-data" action="./upload.php" method="POST">
            <div>
                <label for="file_field">Отправить файл:</label>
                <br>
                <input name="userfile" type="file" />
            </div>
            <br>
            <input type="submit" value="Отправить файл" />
        </form>
        <br><a href="/index.php">На главную</a>
        <h1> Файлы сервера </h1>
        <table cellspacing="0" , style="width:100%">
        <?php
        $scanned_directory = array_diff(scandir('./files'), array('..', '.'));
        if (count($scanned_directory) > 0) {
            foreach ($scanned_directory as $file) {
                echo "<tr><td><a class='filelink' href='./files/" . $file . "'>" . $file . "</a></td></tr>";
            }
        }
        ?>
    </table>
    </div>
</body>

</html>