<?php
// On start
session_start();
date_default_timezone_set("Europe/Moscow");
require_once $_SERVER['DOCUMENT_ROOT'] . '/_helper.php';
$ControllerClass = main();