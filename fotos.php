<?php

importar("Utilidades.Galerias.Lista.ListaGaleriaCategorias");
importar("LojaVirtual.Produtos.ProdutoBusca");

if(!empty($procura2)){

	include('detalhesfoto.php');

}else{
	
	$iTP = new InterFaces(new Arquivos(Sistema::$layoutCaminhoDiretorio."galerias.html"));

	$iTP->setSESSION($_SESSION);
	
	$lGC = new ListaGaleriaCategorias;	
	
	if(!empty($_GET['idcategoria']))
		$lGC->condicoes('', $_GET['idcategoria'], ListaGaleriaCategorias::ID);
	elseif(!empty($procura)){
		
		$lU = new ListaURLs;
		
		$cond[1] = array('campo' => ListaURLs::URL, 	'valor' => $procura);
		$cond[2] = array('campo' => ListaURLs::TABELA, 	'valor' => $lGC->getTabela());
		
		if($lU->condicoes($cond)->getTotal() > 0){
			$lGC->condicoes('', $lU->listar()->valor, ListaProdutos::ID);	
		}
	
	}
	
	$iTP->createRepeticao("repetir->Galerias");
	if($lGC->getTotal() > 0){
		
		$gC = $lGC->listar();
		
		$iTP->trocar("titulo.GaleriaCategoria", $idioma->getTraducaoByConteudo($gC->titulo)->traducao);
		
		if($gC->getGalerias()->getTotal() > 0){
			
			if($gC->getGalerias()->getTotal() == 1){
				$g = $gC->getGalerias()->listar();
				header("Location: ".Sistema::$caminhoURL.$_SESSION['lang']."/fotos/".$gC->getURL()->url."/".$g->getURL()->url);
				exit;
			}
			
			while($g = $gC->getGalerias()->listar()){
				$iTP->repetir();
				
				$iTP->enterRepeticao()->condicao('condicao->Coluna', $gC->getGalerias()->getParametros()%3 == 0);
				
				if($g->getImagens()->getTotal() > 0){
					$img = $g->getImagens()->listar("DESC", ListaImagens::DESTAQUE);
					$iTP->enterRepeticao()->trocar('imagem.Galeria', $img->getImage()->showHTML(225, 180));
					$iTP->enterRepeticao()->trocar('225.url.Imagem.Galeria', $img->getImage()->pathImage(225, 180));
				}
				
				$iTP->enterRepeticao()->trocar("titulo.Galeria", $idioma->getTraducaoByConteudo($g->titulo)->traducao);
				$iTP->enterRepeticao()->trocar("linkVisualizar.Galeria", Sistema::$caminhoURL.$_SESSION['lang']."/fotos/".$gC->getURL()->url."/".$g->getURL()->url);
				
			}
		
		}
	}
	
	$javaScript .= $iTP->createJavaScript()->concluir();
	
	$includePagina = $iTP->concluir();
	
}

?>