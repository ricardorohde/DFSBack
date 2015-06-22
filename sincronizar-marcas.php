<?php

ini_set("memory_limit", "256M");

include('lib.conf/includes.php');

importar('LojaVirtual.Produtos.Lista.ListaProdutoMarcas');
importar("Utils.Arquivos");
importar("Utils.Templates");
importar("Utils.Dados.Strings");

$con = BDConexao::__Abrir();
$lPM = new ListaProdutoMarcas;

try{
	
	$con->executar("SELECT * FROM marcas");
	while($rs = $con->getRegistro()){
		
		if($rs['mar_codigo'] > 0){
		
			$lPM->condicoes('', $rs['mar_codigo'], ListaProdutoMarcas::ID);
			if($lPM->getTotal() > 0)
				$pM = $lPM->listar();
			else
				$pM = new ProdutoMarca($rs['mar_codigo']);
			
			$pM->nome = $rs['mar_nome'];
			$pM->getURL()->setURL('marca-'.strtolower(Strings::__RemoveAcentos(str_replace("'", "", str_replace("\"", "", str_replace(" ", "-", str_replace("/", "-", $pM->nome)))))));
			$pM->disponivel = true;
			
			if($lPM->getTotal() > 0)
				$lPM->alterar($pM);
			else
				$lPM->inserir($pM);
			
		}
		
	}
	
	echo 'SUCESSO!';
	
}catch(\Exception $e){
	echo $e->getMessage();
}

$con->close();
$lPM->close();

?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo Sistema::$nomeEmpresa;?></title>
<link rel="stylesheet" type="text/css" href="lib.js/jQuery/css/bootstrap/bootstrap.css">
<style type="text/css">
html, body {
	width: 100%;
	height: 100%;
}
body,td,th {
	font-size: 12px;
	color: #FFF;
}
div {
	width: 500px;
	margin: 20px 0 0 0;
}
</style>
</head>

<body>

<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td align="center" valign="middle"> 
            <div class="alert alert-info">
            	Marcas sincronizadas com sucesso!
            </div>
        </td>
	</tr>
</table>
</body>
</html>