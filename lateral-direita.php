<?php

importar("Utilidades.Publicidades.Banners.Lista.ListaBannerCategorias");

$iLD = new InterFaces(new Arquivos(Sistema::$layoutCaminhoDiretorio."lateral-direita.html"));
$iLD->trocar('lang', $_SESSION['lang']);
$iLD->setSession($_SESSION);
$iLD->condicao("condicao->Usuario", !empty($_SESSION['usuario']));

/*$lBC = new ListaBannerCategorias;
$lBC->condicoes('', 1, ListaBannerCategorias::ID);
if($lBC->getTotal() > 0){
		
	$bC = $lBC->listar();
	
	$total = 0;
	$iLD->createRepeticao("repetir->Banners");
	while($b = $bC->getBanners()->listar('ASC', ListaBanners::DATAINICIO)){
		
		if($b->ativo){
			$iLD->repetir();
			$total++;
			$iLD->enterRepeticao()->trocar('url.Imagem.Banner', $b->getImagem()->pathImage(219, 2000));
			$iLD->enterRepeticao()->trocar('imagem.Banner', $b->getImagem()->showHTML(219, 2000));
			$iLD->enterRepeticao()->trocar('enderecoURL.Banner', $b->enderecoURL);
			$iLD->enterRepeticao()->trocar('legenda.Banner', $b->legenda);
			$iLD->enterRepeticao()->trocar('posicao.Banners', $total);

		}
	
	}
	
	$iLD->condicao('condicao->Banners', $total > 0);
	
}else
	$iLD->condicao('condicao->Banners', false);*/
	
$lPM = new ListaProdutoMarcas;
$iLD->createRepeticao("repetir->ProdutoMarcas");
while($pM = $lPM->listar("DESC", "rand()")){
	if($pM->getImagem()->nome != ''){
		$iLD->repetir();
		$iLD->enterRepeticao()->trocar("imagem.ProdutoMarca", $pM->getImagem()->showHTML(220, 1000));
		$iLD->enterRepeticao()->trocar("url.Imagem.ProdutoMarca", $pM->getImagem()->pathImage(220, 1000));
		$iLD->enterRepeticao()->trocar("enderecoURL.ProdutoMarca", $pM->enderecoURL);
		$iLD->enterRepeticao()->trocar("linkVisualizar.ProdutoMarca", Sistema::$caminhoURL.$_SESSION['lang']."/produtos&marca=".$pM->getURL()->url);
	}
}

$javaScript .= $iLD->createJavaScript()->concluir();

$lateralDireita = $iLD->concluir();

?>