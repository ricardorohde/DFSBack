<?php

importar("Utilidades.Lista.ListaNoticias");

$iTR = new InterFaces(new Arquivos(Sistema::$layoutCaminhoDiretorio."representantes.html"));

$lN = new ListaNoticias;
$iTR->createRepeticao("repetir->Estados");
while($n = $lN->listar()){
	$texto = strip_tags($n->getTexto()->texto);
	if(!empty($texto)){
		$iTR->repetir();
		$iTR->enterRepeticao()->trocar("titulo.Estado", utf8_encode($n->getTexto()->titulo));
		$iTR->enterRepeticao()->trocar("linkVisualizar.Estado", Sistema::$caminhoURL.$_SESSION['lang']."/representantes/".$n->getURL()->url);
	}
}

if(!empty($_GET['noticia']))
	$lT->condicoes('', $_GET['noticia'], ListaNoticias::ID);
elseif(!empty($procura) || !empty($pagina)){
	
	$lU = new ListaURLs;
	
	if(!empty($procura))
		$cond[1] = array('campo' => ListaURLs::URL, 	'valor' => $procura);
	else
		$cond[1] = array('campo' => ListaURLs::URL, 	'valor' => $pagina);
		
	$cond[2] = array('campo' => ListaURLs::TABELA, 	'valor' => $lN->getTabela());
	
	if($lU->condicoes($cond)->getTotal() > 0){
		$lN->condicoes('', $lU->listar()->valor, ListaNoticias::ID);	
	}

}

if($lN->getTotal() > 0){
	$n = $lN->listar();
	
	$iTR->trocar("titulo.Estado", $n->getTexto()->titulo);
	$iTR->trocar("texto.Estado", $n->getTexto()->texto);	
}

$javaScript .= $iTR->createJavaScript()->concluir();
$includePagina = $iTR->concluir();

?>