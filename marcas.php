<?php

importar("LojaVirtual.Produtos.Lista.ListaProdutoMarcas");
importar("LojaVirtual.Produtos.ProdutoBusca");

$iTP = new InterFaces(new Arquivos(Sistema::$layoutCaminhoDiretorio."marcas.html"));

$iTP->setSESSION($_SESSION);

$iTP->trocar('titulo', $idioma->getTraducaoByConteudo('Marcas')->traducao);

$lPM = new ListaProdutoMarcas;
$iTP->createRepeticao('repetir->ProdutoMarcas');
//$lPM->setGroup(ListaProdutoMarcas::CODIGO);
while($pM = $lPM->listar("ASC", ListaProdutoMarcas::NOME)){
	
	if(file_exists($pM->getImagem()->url)){
	
		$iTP->repetir();
		
		$iTP->enterRepeticao()->trocar("nome.ProdutoMarca", $pM->nome);
		$iTP->enterRepeticao()->trocar("url.Imagem.ProdutoMarca", $pM->getImagem()->pathImage(150, 150));
		$iTP->enterRepeticao()->trocar("linkVisualizar.ProdutoMarca", Sistema::$caminhoURL.$_SESSION['lang']."/produtos&marca=".$pM->getURL()->url);
	
	}
	
}

$javaScript .= $iTP->createJavaScript()->concluir();

$includePagina = $iTP->concluir();