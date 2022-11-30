<head>
  <title>Главная</title>
</head>
<?php
require_once getFileFromRoot('/home/_auth_form.php');
?>
<div class="container">
  <div class="px-4 py-5 my-5 text-center">
    <img class="d-block mx-auto mb-4" src="https://www.graphicpie.com/wp-content/uploads/2020/11/red-among-us-png.png" alt="" width="72" height="57">
    <h1 class="display-5 fw-bold">Centered hero</h1>
    <div class="col-lg-6 mx-auto">
      <p class="lead mb-4">Quickly design and customize responsive mobile-first sites with Bootstrap, the world’s most popular front-end open source toolkit, featuring Sass variables and mixins, responsive grid system, extensive prebuilt components, and powerful JavaScript plugins.</p>
      <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
        <a class="btn btn-primary btn-lg px-4 gap-3" href="/home/track.php" role="button">Отслеживание</a>
        <button type="button" class="btn btn-primary btn-lg px-4" data-bs-toggle="modal" data-bs-target="#loginModal">Авторизация</button>
      </div>
    </div>
  </div>
</div>