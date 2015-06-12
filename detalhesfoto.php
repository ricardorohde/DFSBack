<?php

importar("Utilidades.Galerias.Lista.ListaGalerias");
importar("Utilidades.UploadsDownloads.Lista.ListaUploadDownloadCategorias");

$iTDG = new InterFaces(new Arquivos(Sistema::$layoutCaminhoURL."detalhesgaleria.html"));
$num = 9;	

$iTDG->setSESSION($_SESSION);
$iTDG->trocar("lang", $_SESSION['lang']);

$lGC = new ListaGaleriaCategorias;

if(!empty($_GET['idcategoria']))
	$lGC->condicoes('', $_GET['idcategoria'], ListaGaleriaCategorias::ID);
elseif(!empty($procura)){
	
	$lU = new ListaURLs;
	
	$cond[1] = array('campo' => ListaURLs::URL, 	'valor' => $procura);	
	$cond[2] = array('campo' => ListaURLs::TABELA, 	'valor' => $lGC->getTabela());
	
	if($lU->condicoes($cond)->getTotal() > 0){
		$lGC->condicoes('', $lU->listar()->valor, ListaGalerias::ID);	
	}

}

if($lGC->getTotal() > 0)
	$gC = $lGC->listar();
else
	$gC = new GaleriaCategoria;

$lG = new ListaGalerias;

if(!empty($_GET['idgaleria']))
	$lG->condicoes('', $_GET['idgaleria'], ListaGalerias::ID);
elseif(!empty($procura2)){
	
	$lU = new ListaURLs;
	
	$cond[1] = array('campo' => ListaURLs::URL, 	'valor' => $procura2);	
	$cond[2] = array('campo' => ListaURLs::TABELA, 	'valor' => $lG->getTabela());
	
	if($lU->condicoes($cond)->getTotal() > 0){
		
		$lG->condicoes('', $lU->listar()->valor, ListaGalerias::ID);	
	}

}

if($lG->getTotal() > 0){
	
	$g = $lG->listar();
	
	$iTDG->trocar('navegador.Galeria', "<a href='".Sistema::$caminhoURL.$_REQUEST['lang']."/eventos'>{traduzir->Eventos}</a>".' > '.$idioma->getTraducaoByConteudo($g->titulo)->traducao);
	
	$iTDG->trocar('titulo.GaleriaCategoria', $idioma->getTraducaoByConteudo($gC->titulo)->traducao);
	$iTDG->trocar('linkVisualizar.GaleriaCategoria', Sistema::$caminhoURL.$_SESSION['lang']."/fotos/".$gC->getURL()->url);
	$iTDG->trocar('titulo', $idioma->getTraducaoByConteudo($g->titulo)->traducao);
	$iTDG->trocar('descricao', $idioma->getTraducaoByConteudo($g->descricao)->traducao);
	$iTDG->trocar('data', $g->getData()->mostrar("d/m/Y"));
	$iTDG->trocar('total.Imagens', $g->getImagens()->getTotal());
	
	$iTDG->trocar('url', $g->getURL()->url);
	
	$iTDG->condicao("condicao->imagens", $g->getImagens()->getTotal() > 0);
	
	$m = new MD5;
	
	if($g->getImagens()->getTotal() > 0){
	
		$iTDG->createRepeticao("repetir->Imagens");
		
		//$p = $_GET['pag']*$num;
		//$g->getImagens()->setParametros($num+$p, 'limite')->setParametros($p);
		$iTDG->trocar('posicao.Imagens', empty($p) ? 1 : $p+1);
		$anterior = '';
		
		//$n = 0;
		
		while($img = $g->getImagens()->listar("DESC", ListaImagens::DESTAQUE)){
			
			$iTDG->repetir();
			
			//$n++;
			
			$iTDG->enterRepeticao()->trocar('376.282.anterior.url.imagem.Imagem', $anterior);
			
			$iTDG->enterRepeticao()->trocar('posicao.Imagem', $g->getImagens()->getParametros());
			$iTDG->enterRepeticao()->trocar('legenda.Imagem', nl2br($img->legenda));
			$iTDG->enterRepeticao()->trocar('url.Imagem', Sistema::$caminhoURL.Sistema::$caminhoDataGalerias.$img->getImage()->nome.'.'.$img->getImage()->extensao);
			$iTDG->enterRepeticao()->trocar('290.290.url.imagem.Imagem', $img->getImage()->pathImage(290, 290));
			$iTDG->enterRepeticao()->trocar('125.125.url.imagem.Imagem', $img->getImage()->pathImage(250, 1000));
			$iTDG->enterRepeticao()->trocar('imagem.Imagem', $img->getImage()->showHTML(800, 800));
						
		}
		
		//$iTDG->trocar('totalPag.Imagens', $n);
	
	}
	
	$g->getImagens()->setParametros(0);
	$img = $g->getImagens()->listar("DESC", ListaImagens::DESTAQUE);
	if(!empty($img)){
		$iTDG->trocar('imagem', $img->getImage()->showHTML(290, 290));
		$iTDG->trocar('url.Imagem', $img->getImage()->pathImage(700, 550));
	}
	
	//if($iTDG->enterRepeticao())
		//$iTDG->enterRepeticao()->trocar('376.282.proximo.url.imagem.Imagem', 'proximo');
	/*
	$max = $g->getImagens()->getTotal()/$num;
	$limite = number_format($max);
	if($limite < $max) $limite++;
	
	/$iTDG->condicao('condicao->paginador.Imagens', $limite > 1);
	
	if($limite > 1){
		
		for($i = 1; $i <= $limite; $i++){
			
			$link = $i-1;
			
			if($link == $_GET['pag']){
				$paginador .= "<strong>".$i."</strong>";	
			}else{
				$paginador .= "<a href='".Sistema::$caminhoURL.$_REQUEST['lang']."/galerias/".$g->getURL()->getURL()."/&pag=".$link."'>".$i."</a>";
			}
			
			if($i < $limite)
				$paginador .= ' - ';
			
		}
		
	}
	
	$iTDG->trocar('paginador.Imagens', $paginador);
	
	$iTDG->condicao('condicao->anterior.Imagens', $p > 0);
	$iTDG->trocar('linkAnterior.Imagens', Sistema::$caminhoURL.$_REQUEST['lang'].'/galerias/'.$g->getURL()->getURL().'/&pag='.($_GET['pag']-1));
	if($procura == 'fotos')
		$iTDG->condicao('condicao->proximo.Imagens', $g->getImagens()->getTotal() > $p+$num+1);
	else
		$iTDG->condicao('condicao->proximo.Imagens', $g->getImagens()->getTotal() > $p+1);
	$iTDG->trocar('linkProximo.Imagens', Sistema::$caminhoURL.$_REQUEST['lang'].'/galerias/'.$g->getURL()->getURL().'/&pag='.($_GET['pag']+1));
	*/
	
	


	$iTDG->trocar('titulo.GaleriaCategoria', $idioma->getTraducaoByConteudo($gC->titulo)->traducao);
	$iTDG->trocar('titulo', 	$idioma->getTraducaoByConteudo($g->titulo)->traducao);
	$iTDG->trocar('descricao', 	$idioma->getTraducaoByConteudo($g->descricao)->traducao);
	$iTDG->trocar('local', 	$idioma->getTraducaoByConteudo($g->local)->traducao);
	
	$iTDG->condicao('condicao->video', $g->getVideo() != '');
	if($g->getVideo() != '')
		$iTDG->trocar('video', $g->getVideo());
	
}

$javaScript .= $iTDG->createJavaScript()->concluir();

$iTDG->trocar("linkVoltar", Sistema::$caminhoURL.$_REQUEST['lang'].'/galeria');

$includePagina = $iTDG->concluir();

?>