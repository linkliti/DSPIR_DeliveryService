<head>
  <title>Главная</title>
</head>


<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-4 py-auto shadow">
      <div class="modal-header p-5 pb-4 border-bottom-0">
        <h1 class="fw-bold mb-0 fs-2">Вход</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body p-5 pt-0">
        <form class="">
          <div class="form-floating mb-3">
            <input type="email" class="form-control rounded-3" id="floatingInput" placeholder="name@example.com">
            <label for="floatingInput">Почта</label>
          </div>
          <div class="form-floating mb-3">
            <input type="password" class="form-control rounded-3" id="floatingPassword" placeholder="Password">
            <label for="floatingPassword">Пароль</label>
          </div>
          <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" type="submit">Ввойти</button>
          <small class="text-muted">Вход только для сотрудников службы доставки.</small>
          <hr class="my-4">
        </form>
      </div>
    </div>
  </div>
</div>
<div class="container">
  <div class="px-4 py-5 my-5 text-center">
    <img class="d-block mx-auto mb-4" src="https://www.graphicpie.com/wp-content/uploads/2020/11/red-among-us-png.png" alt="" width="72" height="57">
    <h1 class="display-5 fw-bold">Centered hero</h1>
    <div class="col-lg-6 mx-auto">
      <p class="lead mb-4">Quickly design and customize responsive mobile-first sites with Bootstrap, the world’s most popular front-end open source toolkit, featuring Sass variables and mixins, responsive grid system, extensive prebuilt components, and powerful JavaScript plugins.</p>
      <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
        <button type="button" class="btn btn-primary btn-lg px-4 gap-3">Отслеживание</button>
        <button type="button" class="btn btn-primary btn-lg px-4" data-bs-toggle="modal" data-bs-target="#exampleModal">Авторизация</button>
      </div>
    </div>
  </div>
</div>