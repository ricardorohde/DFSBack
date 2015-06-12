<?php

include("lib.conf/includes.php");
importar("Utils.Dados.JSON");

$con = BDConexao::__Abrir();
$con->executar("SELECT * FROM ".Sistema::$BDPrefixo."produtos_termos_procurados ORDER BY contador DESC LIMIT 30");
$maximo = 0;
while($rs = $con->getRegistro()){
	$tags[] = $rs;
	if ($rs['contador'] > $maximo) $maximo = $rs['contador'];
}

shuffle($tags);
$tags['maximo'] = $maximo;
echo JSON::_Encode($tags);
exit;

?> 