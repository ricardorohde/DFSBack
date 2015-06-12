<?php

importar("Geral.Lista.ListaTextos");

$iTT = new InterFaces(new Arquivos(Sistema::$layoutCaminhoDiretorio."textos.html"));

//include('lateral-esquerda.php');
//$iTT->trocar('lateralEsquerda', $lateralEsquerda);

$lT = new ListaTextos;

if(!empty($_GET['texto']))
	$lT->condicoes('', $_GET['texto'], ListaTextos::ID);
elseif(!empty($procura) || !empty($pagina)){
	
	$lU = new ListaURLs;
	
	if(!empty($procura))
		$cond[1] = array('campo' => ListaURLs::URL, 	'valor' => $procura);
	else
		$cond[1] = array('campo' => ListaURLs::URL, 	'valor' => $pagina);
		
	$cond[2] = array('campo' => ListaURLs::TABELA, 	'valor' => $lT->getTabela());
	
	if($lU->condicoes($cond)->getTotal() > 0){
		$lT->condicoes('', $lU->listar()->valor, ListaTextos::ID);	
	}

}

if($lT->getTotal() > 0){

	$t = $lT->listar();
	
	//metatag
	$titulo = $idioma->getTraducaoByConteudo($t->titulo)->traducao;
	$descricao = $idioma->getTraducaoByConteudo($t->titulo)->traducao;
	//
	
	$iTT->trocar('titulo', ($idioma->getTraducaoByConteudo($t->titulo)->traducao));
	$iTT->trocar('texto', ($idioma->getTraducaoByConteudo($t->texto)->traducao));
	
	if(!empty($t->getImagem()->getImage()->nome))
		$iTT->trocar('imagem', $t->getImagem()->getImage()->showHTML(300, 400));
	
}

$includePagina = $iTT->concluir();

?>