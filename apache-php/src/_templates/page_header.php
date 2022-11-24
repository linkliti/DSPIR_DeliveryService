<?php
$links = array(
  "/home/home.php" => "Главная страница",
  "/home/session_test.php" => "Дебаг",
  "/admin/admin.php" => "Администрирование",
);
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-lg">
  <div class="container">
    <a class="navbar-brand" href="#">Служба доставки</a>
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
        <?php
        # Correct theme switch position
        echo '<input class="form-check-input d-flex"onclick="changeTheme()" type="checkbox" role="switch"id="themeToggle" ';
        echo ($_SESSION['theme']) ? 'checked' : '';
        echo ' >';
        echo '<label class="form-check-label text-light"for="themeToggle">Темная тема</label>';
        ?>
      </div>
    </div>
    <!-- Navbar -->

  </div>
</nav>