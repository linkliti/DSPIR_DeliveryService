<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/controller/_helper.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/view/html_header.php';
?>
<html lang="ru">

<head>
    <title>Каталог</title>
</head>

<body>
    <main id="main">
        <div class="container-lg">
            <h1>Каталог</h1>
            <?php
        require_once '_helper.php';
        $mysqli = openmysqli();
        $result = $mysqli->query("select * from toys");
        ?>
            <div class="card">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>Игрушка</th>
                            <th>Описание</th>
                            <th>Цена</th>
                        </tr>
                        <?php if ($result->num_rows > 0)
                        foreach ($result as $toy) {
                            echo "
            <tr>
                <td>" . $toy['title'] . "</td>
                <td>" . $toy['description'] . "</td>
                <td>" . $toy['cost'] . " руб</td>
            </tr>
            ";
                        } else
                        echo ''; ?>
                    </table>
                </div>
            </div>
            <br><a href="/index.php">На главную</a>
        </div>
    </main>
    <?php $mysqli->close(); ?>
</body>

</html>