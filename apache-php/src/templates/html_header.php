<?php
# Meta
echo '
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
';

# Bootstrap
echo '
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
';
echo '
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js" integrity="sha384-IDwe1+LCz02ROU9k972gdyvl+AESN10+x7tBKgc9I5HFtuNz0wWnPclzo6p9vxnk" crossorigin="anonymous"></script>
';

# JS
echo '<script src="/js/js_stuff.js"></script>';

# CSS
echo '<link rel="stylesheet" href="/css/normalize.css">';
echo '<link rel="stylesheet" href="/css/base.css">';

# Theme
# True = Dark
if ($_SESSION['theme']){
    echo '<link id="pagestyle" rel="stylesheet" href="/css/dark.css">';
}
else {
    echo '<link id="pagestyle" rel="stylesheet" href="/css/light.css">';
}
?>