<?php

include('./lib.conf/includes.php');

importar("Geral.InterFaces");
importar("Geral.Idiomas.Lista.ListaIdiomas");
importar("Geral.Lista.ListaURLs");
importar("TemTudoAqui.Usuarios.Lista.ListaPessoas");
importar("LojaVirtual.Categorias.Lista.ListaProdutoCategorias");
importar("JavaScript.Alertas.Aviso");

$pagina		= $_GET['p'];
$procura	= empty($_GET['procura']) ? '' : $_GET['procura'];
$procura2	= empty($_GET['procura2']) ? '' : $_GET['procura2'];

if(!empty($_SESSION['lang'])){
	
	if(!empty($_GET['lang'])){
		if($_GET['lang'] == 'favicon.ico'){
			$_SESSION['sigla'] = 'br';
			header("Location: ".Sistema::$caminhoURL."br");
		}else
			$_SESSION['sigla'] = $_GET['lang'];
	}else
		header("Location: ".Sistema::$caminhoURL.$_SESSION['lang']);
	
}elseif(!empty($_GET['lang'])){
	if($_GET['lang'] == 'favicon.ico'){
		$_SESSION['sigla'] = 'br';
		header("Location: ".Sistema::$caminhoURL."br");
	}else
		$_SESSION['sigla'] = $_GET['lang'];
}else
	header("Location: ".Sistema::$caminhoURL."br");

$_SESSION['lang'] = $_SESSION['sigla'];

$iT 		= new InterFaces(new Arquivos(Sistema::$layoutCaminhoDiretorio."principal.html"));

$iT->setSESSION($_SESSION);
$iT->trocar('lang', $_SESSION['lang']);

//Idiomas

$lI  		= new ListaIdiomas;
$iT->trocar('linkVisualizar.BR.Idioma', Sistema::$caminhoURL."br"."/".$pagina.(!empty($procura) ? "/".$procura : '').(!empty($procura2) ? "/".$procura2 : ''));
$iT->createRepeticao("repetir->Idiomas");
while($i = $lI->listar()){
	
	$iT->repetir();
	
	if($i->getImagem()->nome != "")
		$iT->enterRepeticao()->trocar('imagem.Idioma', $i->getImagem()->showHTML(50, 13));
	
	$iT->enterRepeticao()->trocar('nome.Idioma', $i->nome);
	$iT->enterRepeticao()->trocar('linkVisualizar.Idioma', Sistema::$caminhoURL.$i->sigla."/".$pagina.(!empty($procura) ? "/".$procura : '').(!empty($procura2) ? "/".$procura2 : ''));
	
}

if($lI->condicoes('', $_SESSION['sigla'], ListaIdiomas::SIGLA)->getTotal() > 0)
	$idioma = $lI->listar();
else
	$idioma = new Idioma;

//

if(!empty($pagina)){
		
	$lU = new ListaURLs;
	
	$cond[1] = array('campo' => ListaURLs::URL, 	'valor' => $pagina);
	
	if($lU->condicoes($cond)->getTotal() > 0){
		
		$u = $lU->listar();
		
	}else
		$u = new URL;
	
}

//Categorias

$lPC = new ListaProdutoCategorias;
$lPC->condicoes('', '', ListaProdutoCategorias::CATEGORIAPAI);
$iT->createRepeticao('repetir->Categorias');
while($pC = $lPC->listar()){
	
	$iT->repetir();
	
	$iT->enterRepeticao()->trocar('nome.Categoria', $pC->nome);
	$iT->enterRepeticao()->trocar('linkVisualizar.Categoria', Sistema::$caminhoURL.$_SESSION['lang']."/produtos/".$pC->getURL()->url);
	
	$iT->enterRepeticao()->condicao('condicao->Categorias', $pC->getSubCategorias()->getTotal() > 0);
	$iT->enterRepeticao()->createRepeticao("repetir->Categorias.Categoria");
	if($pC->getSubCategorias()->getTotal() > 0){
		
		/*while($c = $pC->getSubCategorias()->listar()){
			
			$iT->enterRepeticao()->repetir();
			
			$iT->enterRepeticao()->enterRepeticao()->trocar("nome.Categoria.Categoria", $c->nome);
			$iT->enterRepeticao()->enterRepeticao()->trocar("linkVisualizar.Categoria.Categoria", Sistema::$caminhoURL.$_SESSION['lang']."/produtos/".$c->getURL()->url);
			
		}*/
		
	}
	
}

//

$iT->condicao("condicao->Logout", !empty($_SESSION['usuario']));

if(file_exists($pagina.'.php'))
	include($pagina.'.php');
elseif(file_exists($u->tabela.'.php'))
	include($u->tabela.'.php');
else
	include('main.php');

$iT->trocar('includePagina', $includePagina);

$iT->trocar('javaScript', $javaScript);

$iT->mostrar();

?>