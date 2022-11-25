<!-- Meta -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Bootstrap -->
<script type="text/javascript" src="/js/library/bootstrap.bundle.min.js"></script>


<!-- JS + CSS -->
<script src="/js/themeJS.js"></script>
<link rel="stylesheet" href="/css/base.css">

<?php
# Theme
# True = Dark
if ($_SESSION['theme']){
    echo '<link id="pagestyle" href="/css/library/bootstrap-night.min.css" rel="stylesheet">';
}
else {
    echo '<link id="pagestyle" href="/css/library/bootstrap.min.css" rel="stylesheet">';
}
?>