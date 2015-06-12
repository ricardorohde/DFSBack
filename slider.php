<?php

include('lib.conf/includes.php');

importar("Geral.InterFaces");
importar('Utilidades.Publicidades.Slides.Lista.ListaSlides');

$iT 		= new InterFaces(new Arquivos(Sistema::$layoutCaminhoDiretorio."slider.html"));

$iT->setSESSION($_SESSION);
$iT->trocar('lang', $_SESSION['lang']);

$lSC = new ListaSlideCategorias;
$lSC->condicoes('', 1, ListaSlideCategorias::ID);
if($lSC->getTotal() > 0){
		
	$sC = $lSC->listar();
	
	$total = 0;
	$iT->createRepeticao("repetir->Slides");
	while($s = $sC->getSlides()->listar('ASC', ListaSlides::ORDEM)){
		
		if($s->ativo){
			$iT->repetir();
			$total++;
			$iT->enterRepeticao()->trocar('url.Imagem.Slide', $s->getImagem()->pathImage(2300, 413));
			$iT->enterRepeticao()->trocar('imagem.Slide', $s->getImagem()->showHTML(2300, 413));
			$iT->enterRepeticao()->trocar('enderecoURL.Slide', $s->enderecoURL ? $s->enderecoURL : Sistema::$caminhoURL);
			$iT->enterRepeticao()->trocar('legenda.Slide', $s->legenda);
			$iT->enterRepeticao()->trocar('posicao.Slides', $total);

		}
	
	}
	
	$iT->condicao('condicao->Slides', $total > 0);
	
}else
	$iT->condicao('condicao->Slides', false);

$final = $iT->concluir();

echo $final;

?>