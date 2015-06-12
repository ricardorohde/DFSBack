<?php

include("lib.conf/includes.php");

importar("Geral.Lista");

$l = new Lista("produtos");
$l->clearCache();

echo 'Cache apagado com sucesso!';

?>