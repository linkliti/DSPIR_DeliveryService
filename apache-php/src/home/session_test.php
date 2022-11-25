<head>
  <title>Session Debug Page</title>
</head>


<div class="container mt-4">
  <h1>Session Debug Page</h1>
  <?php
        if (!isset($_SESSION['views'])) {
          $_SESSION['views'] = 0;
        }
        $_SESSION['views']++;
        $current_theme = $_SESSION['theme'] ? 'black' : 'white';
        echo "Your session ID: " . session_id() . "<br>";
        echo "You have visited this page: {$_SESSION['views']} times<br>";
        echo "Last color theme: {$current_theme}<br>";
        ?>
  <br><a href="/home/home.php">На главную</a>
</div>