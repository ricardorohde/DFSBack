<?php

include("lib.conf/includes.php");
error_reporting(E_ALL);

$con = BDConexao::__Abrir();
$con2 = BDConexao::__Abrir();

$con->executar("SELECT * FROM produtos");

if($con->getTotal() > 0){

	$con->executar("
	INSERT INTO ".Sistema::$BDPrefixo."urls (id, url, tabela, campo, valor)
	SELECT p.prd_produto, CONCAT(p.prd_produto, '-', LOWER(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(p.prd_desc, '+', '-'), '\\\', '-'), '/', '-'), '\"', ''), '\'', ''), ' ', '-'), ' > ', '-'))), 'produtos', 'url', p.prd_produto
		FROM produtos p
		WHERE p.envia_site != 'N'
		ON DUPLICATE KEY UPDATE url = CONCAT(p.prd_produto, '-', LOWER(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(p.prd_desc, '+', '-'), '\\\', '-'), '/', '-'), '\"', ''), '\'', ''), ' ', '-'), ' > ', '-'))), tabela = 'produtos', valor = p.prd_produto");

	$con->executar("
	INSERT INTO ".Sistema::$BDPrefixo."produtos (id, url, codigo, marca, nome, valorreal, estoque, disponivel)
	SELECT p.prd_produto, p.prd_produto, p.prd_produto, p.prd_marca, p.prd_desc, p.prd_preco3, p.prd_stock, 1
		FROM produtos p
		WHERE p.envia_site != 'N'
		ON DUPLICATE KEY UPDATE ".Sistema::$BDPrefixo."produtos.nome = p.prd_desc, ".Sistema::$BDPrefixo."produtos.url = p.prd_produto, ".Sistema::$BDPrefixo."produtos.codigo = p.prd_produto, ".Sistema::$BDPrefixo."produtos.marca = p.prd_marca, ".Sistema::$BDPrefixo."produtos.valorreal = p.prd_preco3, ".Sistema::$BDPrefixo."produtos.estoque = p.prd_stock");

	$con->executar("UPDATE ".Sistema::$BDPrefixo."produtos SET disponivel = 0 WHERE id IN (SELECT prd_produto FROM produtos WHERE envia_site = 'N')");

	/*$con->executar("DELETE FROM ".Sistema::$BDPrefixo."produtos
							WHERE id IN (SELECT prd_produto
												FROM produtos
												WHERE envia_site = 'N')");

	$con->executar("DELETE FROM ".Sistema::$BDPrefixo."urls
							WHERE tabela = 'produtos'
								AND valor IN (SELECT prd_produto
												FROM produtos
												WHERE envia_site = 'N')");

	/*$con->executar("DELETE FROM ".Sistema::$BDPrefixo."imagens
							WHERE sessao = 'produtos'
								AND idsessao IN (SELECT prd_produto
												FROM produtos
												WHERE envia_site = 'N')");*/

	$con->executar("DELETE FROM ".Sistema::$BDPrefixo."relacionamento_produtos_categorias");

	$con->executar("
	INSERT INTO ".Sistema::$BDPrefixo."relacionamento_produtos_categorias (produto, categoria)
	SELECT p.prd_produto, c.id
		FROM produtos p
		INNER JOIN ".Sistema::$BDPrefixo."produtos_categorias c
			ON c.subreferencia = p.prd_subrefere
		ON DUPLICATE KEY UPDATE ".Sistema::$BDPrefixo."relacionamento_produtos_categorias.produto = p.prd_produto, ".Sistema::$BDPrefixo."relacionamento_produtos_categorias.categoria = c.id");

}

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
            	Produtos sincronizados com sucesso!
            </div>
        </td>
	</tr>
</table>
</body>
</html>