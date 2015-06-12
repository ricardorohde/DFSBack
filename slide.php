<?php

importar("Utilidades.Publicidades.Slides.Lista.ListaSlideCategorias");

$iTS = new InterFaces(new Arquivos(Sistema::$layoutCaminhoDiretorio."slide.html"));

$lSC = new ListaSlideCategorias;
$lSC->condicoes('', 1, ListaSlideCategorias::ID);
$iTS->createRepeticao('repetir->Slides');
if($lSC->getTotal() > 0){
	
	$sC = $lSC->listar();
	if($sC->getSlides()->getTotal() > 0){
		
		while($s = $sC->getSlides()->listar("ASC", ListaSlides::ORDEM)){
			if($s->ativo && $s->getImagem()->nome != ''){
				$iTS->repetir();
				$iTS->enterRepeticao()->trocar('url.Imagem.Slide', Sistema::$caminhoURL.Sistema::$caminhoDataSlides.$s->getImagem()->nome.".".$s->getImagem()->extensao);
				$iTS->enterRepeticao()->trocar('enderecoURL.Slide', $s->enderecoURL);
			}
		}
		
	}
	
}

$iTS->mostrar();
exit;
?>