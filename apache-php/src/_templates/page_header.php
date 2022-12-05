<?php
$links = array();
$links["/home/session_test.php"] = "Дебаг";
if (checkPrivilege('admin')) {
  $links["/userContent/test.php"] = "Тест";
  $links["/table/workers.php"] = "Персонал";
}
if (checkPrivilege(array('driver', 'manager', 'assembler'))) {
  $links["/table/orders.php"] = "Заказы";
}
if (checkPrivilege(array('manager', 'assembler'))) {
  $links["/table/positions.php"] = "Склад";
}
if (checkPrivilege(array('manager', 'driver'))) {
  $links["/table/pvzs.php"] = "Пункты выдачи";
}
if (checkPrivilege('driver')) {
  $links["/table/vehicles.php"] = "Автомобили";
}
if (checkPrivilege('manager')) {
  $links["/table/clients.php"] = "Клиенты";
}
?>

<script>
  async function deAuth() {
    var btn = document.getElementById('deauthBTN')
    btn.innerHTML = "Отправка запроса..."
    var response = await ftch('DELETE', '/api/user_api.php', '{"deAuth": true}');
    window.location.href = '/home/home.php'
  }
</script>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-lg">
  <div class="container">
    <a class="navbar-brand" href="/home/home.php">Служба доставки</a>
    <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <!-- Navbar -->
    <div class="navbar-collapse collapse" id="navbar">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <?php
        # Show FIO or Auth link
        echo '<li class="nav-item">';
        if (checkPrivilege('is_auth')) {
          echo "<a class='nav-link active'>Вход выполнен<br>Доступ: {$_SESSION['role']}</a>";
        }
        else {
          $entry = array("/home/auth.php" => "Авторизация");
          $links = array_merge($entry, $links);
        }
        # Current tab highlighting
        foreach ($links as $key => $value) {
          echo '<li class="nav-item d-flex align-items-center"> <a class="nav-link ';
          echo ($_SERVER['REQUEST_URI'] == $key) ? 'active' : '';
          echo '" aria-current="page" href="' . $key . '">' . $value . '</a></li>';
        }
        # DeAuth button
        if (isset($_SESSION['role'])) {
          echo '<li class="nav-item d-flex align-items-center"><button id="deauthBTN" role="button" class="btn btn-link nav-link" aria-current="page" onclick="deAuth()">Выход</button></li>';
        }
        ?>
      </ul>
      <div class="form-check form-switch">
        <input class="form-check-input" onclick="changeTheme()" type="checkbox" role="switch" id="themeToggle" <?php echo ($_SESSION['theme']) ? 'checked' : ''; ?>
        ><label class="form-check-label text-light" for="themeToggle">Темная тема</label>
      </div>
    </div>
  </div>
</nav>

<body class="d-flex flex-column h-100">
  <main class="flex-shrink-0"></main>