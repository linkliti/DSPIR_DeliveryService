<head>
  <title>Главная</title>
</head>

<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-4 py-auto shadow">
        <?php require_once getFileFromRoot('/home/_auth_form.php'); ?>
    </div>
  </div>
</div>

<div class="container">
  <?php
  if (checkPrivilege('is_auth')) {
    echo '<h3 class="my-5 fw-bold lh-1 mb-3 text-center">Добро пожаловать '. $_SESSION['fio'] .'</h3>';
  }
  ?>
  <div class="px-4 py-5 my-5 text-center">
    <img class="d-block mx-auto mb-4" src="/images/logo.png" alt=""  width="100" height="100">
    <h1 class="display-5 fw-bold">Служба доставки</h1>
    <div class="col-lg-6 mx-auto">
      <p class="lead mb-4">Мы оказываем людям и компаниям спектр услуг своевременной и гарантированной доставки, постоянно повышая уровень сервиса, внедряя новые технологии, эффективно используя внутренний потенциал и внешние ресурсы.</p>
      <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
        <a class="btn btn-primary btn-lg px-4 gap-3" href="/home/track.php" role="button">Отслеживание</a>
        <?php
        if (checkPrivilege('is_auth')) {
          echo '<button type="button" class="formBTN btn btn-primary btn-lg px-4" onclick="deAuth()">Выход</button>';
        }
        else {
          echo '<button type="button" class="btn btn-primary btn-lg px-4" data-bs-toggle="modal" data-bs-target="#loginModal">Авторизация</button>';
        }
        ?>
      </div>
    </div>
  </div>
</div>