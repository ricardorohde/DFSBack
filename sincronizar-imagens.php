<?php

include("lib.conf/includes.php");

importar("LojaVirtual.Produtos.Lista.ListaProdutos");
importar("LojaVirtual.Produtos.Lista.ListaProdutoImagens");

$con = BDConexao::__Abrir();
$con2 = BDConexao::__Abrir();

$con->executar("
INSERT INTO dfs_imagens d (sessao, idsessao, imagem, legenda, destaque)
  SELECT t.sessao, t.idsessao, t.imagem, t.legenda, t.destaque
    FROM tta_imagens t
    WHERE t.sessao = 'produtos'
    ON DUPLICATE KEY UPDATE d.".Sistema::$BDPrefixo."destaque = t.destaque
");

/*$con->executar("SELECT p.prd_produto, (SELECT COUNT(i.id) FROM ".Sistema::$BDPrefixo."imagens i WHERE i.sessao = 'produtos' AND i.idsessao = p.prd_produto) as total FROM produtos p");
while($rs = $con->getRegistro()){
	for($i = $rs['total'] > 0 ? $rs['total']+1 : 1; $i <= 30; $i++){
		$arq = Sistema::$caminhoDiretorio."fotos/".$rs['prd_produto']."_".$i.".jpg";
		//var_dump($arq); exit;
		if(!file_exists($arq))
			break;
		else{
			if($i == 1)
				$destaque = 1;
			else
				$destaque = 0;
			$con2->executar("INSERT INTO ".Sistema::$BDPrefixo."imagens (sessao, idsessao, imagem, destaque) VALUES('produtos', '".$rs['prd_produto']."', '".$rs['prd_produto']."_".$i.".jpg', '".$destaque."')");
			//copy($arq, Sistema::$caminhoDiretorio.Sistema::$caminhoDataProdutos.$rs['prd_produto']."_".$i.".jpg");
		}
	}
}*/

$con->close();
$con2->close();

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
            	Imagens sincronizados com sucesso!
            </div>
        </td>
	</tr>
</table>
</body>
</html>