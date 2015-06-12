<?php

importar("Utilidades.Galerias.Lista.ListaGalerias");
importar("LojaVirtual.Produtos.ProdutoBusca");

if(!empty($procura)){

	include('detalhesgaleria.php');

}else{
	
	$iTP = new InterFaces(new Arquivos(Sistema::$layoutCaminhoDiretorio."eventos.html"));

	$iTP->setSESSION($_SESSION);

	$lG = new ListaGalerias;
	$iTP->createRepeticao("repetir->Eventos");
	while($g = $lG->listar()){
		$iTP->repetir();
		
		if($g->getImagens()->getTotal() > 0){
			$img = $g->getImagens()->listar("DESC", ListaImagens::DESTAQUE);
			$iTP->enterRepeticao()->trocar('imagem.Evento', $img->getImage()->showHTML(1000, 230));
		}
		
		$iTP->enterRepeticao()->trocar("titulo.Evento", utf8_encode($g->titulo));
		$iTP->enterRepeticao()->trocar("linkVisualizar.Evento", Sistema::$caminhoURL.$_SESSION['lang']."/eventos/".$g->getURL()->url);
		
	}
	
	$javaScript .= $iTP->createJavaScript()->concluir();
	
	$includePagina = $iTP->concluir();
	
}

?>