<?php

importar("Utilidades.Galerias.Lista.ListaGalerias");
importar("Utilidades.UploadsDownloads.Lista.ListaUploadDownloadCategorias");

$iTDG = new InterFaces(new Arquivos(Sistema::$layoutCaminhoURL."detalhesgaleria.html"));
$num = 9;	

$iTDG->setSESSION($_SESSION);
$iTDG->trocar("lang", $_SESSION['lang']);

$lG = new ListaGalerias;

if(!empty($_GET['idgaleria']))
	$lG->condicoes('', $_GET['idgaleria'], ListaGalerias::ID);
elseif(!empty($procura)){
	
	$lU = new ListaURLs;
	
	$cond[1] = array('campo' => ListaURLs::URL, 	'valor' => $procura);	
	$cond[2] = array('campo' => ListaURLs::TABELA, 	'valor' => $lG->getTabela());
	
	if($lU->condicoes($cond)->getTotal() > 0){
		
		$lG->condicoes('', $lU->listar()->valor, ListaGalerias::ID);	
	}

}

if($lG->getTotal() > 0){
	
	$g = $lG->listar();
	
	$iTDG->trocar('navegador.Galeria', "<a href='".Sistema::$caminhoURL.$_REQUEST['lang']."/eventos'>{traduzir->Eventos}</a>".' > '.utf8_encode($idioma->getTraducaoByConteudo($g->titulo)->traducao));
	
	$iTDG->trocar('data', $g->getData()->mostrar("d/m/Y"));
	$iTDG->trocar('total.Imagens.Galeria', $g->getImagens()->getTotal());
	
	$iTDG->trocar('url.Galeria', $g->getURL()->url);
	
	$iTDG->trocar('titulo', 	$idioma->getTraducaoByConteudo($g->titulo)->traducao);
	$iTDG->trocar('descricao', 	$idioma->getTraducaoByConteudo($g->descricao)->traducao);
	
	$iTDG->condicao('condicao->video.Galeria', $g->getVideo() != '');
	if($g->getVideo() != '')
		$iTDG->trocar('video.Galeria', $g->getVideo());
	
	$iTDG->condicao("condicao->imagens.Galeria", $g->getImagens()->getTotal() > 0);
	
	$m = new MD5;
	
	if($g->getImagens()->getTotal() > 0){
	
		$iTDG->createRepeticao("repetir->Imagens.Galeria");
		
		//$p = $_GET['pag']*$num;
		//$g->getImagens()->setParametros($num+$p, 'limite')->setParametros($p);
		$iTDG->trocar('posicao.Imagens.Galeria', empty($p) ? 1 : $p+1);
		$anterior = '';
		
		//$n = 0;
		
		while($img = $g->getImagens()->listar("ASC", ListaImagens::ID)){
			
			$iTDG->repetir();
			
			//$n++;
			
			$iTDG->enterRepeticao()->trocar('376.282.anterior.url.imagem.Imagem.Galeria', $anterior);
			
			$iTDG->enterRepeticao()->trocar('posicao.Imagens.Galeria', $g->getImagens()->getParametros());
			$iTDG->enterRepeticao()->trocar('600.600.url.imagem.Imagem.Galeria', Sistema::$caminhoURL.Sistema::$caminhoDataGalerias.$img->getImage()->nome.'.'.$img->getImage()->extensao);
			$iTDG->enterRepeticao()->trocar('376.282.url.imagem.Imagem.Galeria', $img->getImage()->pathImage(376, 282));
			$iTDG->enterRepeticao()->trocar('imagem.Galeria', $img->getImage()->showHTML(800, 800));
			$iTDG->enterRepeticao()->trocar('1000.230.url.imagem.Imagem.Galeria', Sistema::$caminhoURL.'lib.conf/abrirArquivo.php?caminho='.$m->criptografar(Sistema::$caminhoURL.Sistema::$caminhoDataGalerias.$img->getImage()->nome.'.'.$img->getImage()->extensao)."&w=1000&h=230");
						
		}
		
		//$iTDG->trocar('totalPag.Imagens.Galeria', $n);
	
	}
	
	//if($iTDG->enterRepeticao())
		//$iTDG->enterRepeticao()->trocar('376.282.proximo.url.imagem.Imagem.Galeria', 'proximo');
	/*
	$max = $g->getImagens()->getTotal()/$num;
	$limite = number_format($max);
	if($limite < $max) $limite++;
	
	/$iTDG->condicao('condicao->paginador.Imagens.Galeria', $limite > 1);
	
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
	
	$iTDG->trocar('paginador.Imagens.Galeria', $paginador);
	
	$iTDG->condicao('condicao->anterior.Imagens.Galeria', $p > 0);
	$iTDG->trocar('linkAnterior.Imagens.Galeria', Sistema::$caminhoURL.$_REQUEST['lang'].'/galerias/'.$g->getURL()->getURL().'/&pag='.($_GET['pag']-1));
	if($procura == 'fotos')
		$iTDG->condicao('condicao->proximo.Imagens.Galeria', $g->getImagens()->getTotal() > $p+$num+1);
	else
		$iTDG->condicao('condicao->proximo.Imagens.Galeria', $g->getImagens()->getTotal() > $p+1);
	$iTDG->trocar('linkProximo.Imagens.Galeria', Sistema::$caminhoURL.$_REQUEST['lang'].'/galerias/'.$g->getURL()->getURL().'/&pag='.($_GET['pag']+1));
	*/
}

$javaScript .= $iTDG->createJavaScript()->concluir();

$iTDG->trocar("linkVoltar.Galeria", Sistema::$caminhoURL.$_REQUEST['lang'].'/galeria');

$includePagina = $iTDG->concluir();

?>