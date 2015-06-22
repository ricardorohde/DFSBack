<?php

ini_set("memory_limit", "256M");

include('lib.conf/includes.php');

importar('LojaVirtual.Categorias.Lista.ListaProdutoCategorias');
importar("Utils.Arquivos");
importar("Utils.Templates");
importar("Utils.Dados.Strings");

$con = BDConexao::__Abrir();
$con2 = BDConexao::__Abrir();
$con3 = BDConexao::__Abrir();
$con4 = BDConexao::__Abrir();
$lPC = new ListaProdutoCategorias;

try{

    $lPC = new ListaProdutoCategorias();
    $lPC2 = new ListaProdutoCategorias();
    while($pC = $lPC->listar()){
        $pCP = new ProdutoCategoria($pC->getIdCategoriaPai());
        if($pCP->getId() > 0) {
            $pCP = $lPC2->condicoes('', $pCP->getId(), ListaProdutoCategorias::ID)->listar();
        }
        $pC->getURL()->setURL(($pCP->getId() > 0 ? strtolower(Strings::__RemoveAcentos(str_replace("'", "", str_replace("\"", "", str_replace(" ", "-", str_replace(" > ", "-", str_replace("/", "-", $pCP->getNavegador(new Templates(Arquivos::__Create("{nome}"))))))))))."-" : '').strtolower(Strings::__RemoveAcentos(str_replace("'", "", str_replace("\"", "", str_replace(" ", "-", str_replace("/", "-", $pC->nome)))))));
        $lPC2->alterar($pC);
    }
	
	echo 'SUCESSO!';
	
}catch(\Exception $e){
	echo $e->getMessage();
}

$con->close();
$con2->close();
$con3->close();
$con4->close();
$lPC->close();

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
    color: #333;
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
            	Categorias sincronizados com sucesso!
            </div>
        </td>
	</tr>
</table>
</body>
</html>