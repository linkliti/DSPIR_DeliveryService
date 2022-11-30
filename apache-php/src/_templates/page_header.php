<?php
$links = array(
  "/home/session_test.php" => "Дебаг",
  "/table/workers.php" => "Персонал",
  "/table/orders.php" => "Заказы",
  "/table/positions.php" => "Склад",
  "/table/vehicles.php" => "Автомобили",
  "/table/pvzs.php" => "ПВЗ",
  "/table/clients.php" => "Клиенты",
);
?>

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
        # Current tab highlighting
        foreach ($links as $key => $value) {
          echo '<li class="nav-item"> <a class="nav-link ';
          echo ($_SERVER['REQUEST_URI'] == $key) ? 'active' : '';
          echo '" aria-current="page" href="' . $key . '">' . $value . '</a></li>';
        }
        ?>
      </ul>
      <div class="form-check form-switch">
        <input class="form-check-input" onclick="changeTheme()" type="checkbox" role="switch" id="themeToggle"
        <?php
        echo ($_SESSION['theme']) ? 'checked' : '';
        ?>
        ><label class="form-check-label text-light" for="themeToggle">Темная тема</label>
      </div>
    </div>

  </div>
</nav>

<body class="d-flex flex-column h-100">
  <main class="flex-shrink-0"></main>