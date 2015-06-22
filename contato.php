<?php

importar("Geral.Lista.ListaTextos");
importar("Utils.EnvioEmail");
importar("JavaScript.Alertas.Aviso");

$iTT = new InterFaces(new Arquivos(Sistema::$layoutCaminhoDiretorio."contato.html"));
$iTT->setSession($_SESSION);
$iTT->trocar('lang', $_SESSION['lang']);

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
if(!empty($_POST['mensagem'])){	

	$temE = new InterFaces(new Arquivos(Sistema::$adminLayoutCaminhoDiretorio."/email-padrao.html"));
	
	$msg = "<br /><br />Nome: ".$_POST['nome']."<br />E-mail: ".$_POST['email']."<br />Mensagem:<br />".$_POST['mensagem']."<br /><br />";
	
	$temE->trocar('texto', $msg);
	$msg = ($temE->concluir());
	
	EnvioEmail::$para = Sistema::$emailEmpresa;
	EnvioEmail::$de = utf8_decode($_POST['nome'])."<".$_POST['email'].">";
	EnvioEmail::$assunto = utf8_decode("Contato pelo site ".Sistema::$nomeEmpresa);
	EnvioEmail::$msg = $msg;
	EnvioEmail::$html = true;

	EnvioEmail::enviar();
	
	$iTT->trocar('mensagemEnviado', 'Agradecemos seu contato, em breve retornaremos seu contato.');
	
}
if($lT->getTotal() > 0){

	$t = $lT->listar();	
	$iTT->trocar('titulo', $idioma->getTraducaoByConteudo($t->titulo)->traducao);
	$iTT->trocar('texto', $idioma->getTraducaoByConteudo($t->texto)->traducao);
	
}
$javaScript .= $iTT->createJavaScript()->concluir();
$includePagina = $iTT->concluir();
?>