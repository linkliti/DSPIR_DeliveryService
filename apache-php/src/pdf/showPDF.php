<head>
    <title>PDF файлы</title>
</head>
<div class="container">
    <h1 class="mt-4">Загрузка файлов PDF</h1>
    <form enctype="multipart/form-data" action="./upload.php" method="POST">
        <div class="w-50">
            <label for="file_field" class="form-label">Отправить файл:</label>
            <br>
            <input class="form-control" name="userfile" type="file" />
        </div>
        <br>
        <input class="btn btn-primary" type="submit" value="Отправить файл" />
    </form>
    <h1> Файлы сервера </h1>
    <table cellspacing="0" class="w-100">
        <?php
        $filelist = 'files'; // ignore errors
        if (is_array($$filelist)) {
            foreach ($$filelist as $file) {
                echo "<tr><td><a class='text-body' href='/userContent/files/" . $file . "'>" . $file . "</a></td></tr>";
            }
        } else
            echo "<p>На сервере нет файлов 😟</p>";
        ?>
    </table>
</div>