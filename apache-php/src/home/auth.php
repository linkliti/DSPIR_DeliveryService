<?php
    if (checkPrivilege('is_auth')) {
        //header("location: /home/home.php");
    }
?>
<head>
    <title>Авторизация</title>
</head>

<div class="container col-sm-12 col-md-8 col-lg-6 mx-auto">
    <div class="col-12">
    <?php require_once getFileFromRoot('/home/_auth_form.php'); ?>
    </div>
</div>