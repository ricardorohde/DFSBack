<?php

include_once('lib.conf/includes.php');

unset($_SESSION['usuario']);
header('Location: '.Sistema::$caminhoURL.$_SESSION['lang']);
exit;

?>