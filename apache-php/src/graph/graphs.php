<head>
  <title>Графики</title>
</head>

<div class="container-lg mt-4">
  <h1 class="mb-4">Графики</h1>
  <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-1">
    <?php
      foreach ($images as $image) {
        echo '<div class="col"><div class="card"><img src="';
        echo $image;
        echo '" width="100%" height="100%"></div></div>';
      }
    ?>
  </div>
</div>