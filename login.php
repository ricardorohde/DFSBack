<?php

importar("TemTudoAqui.Usuarios.Lista.ListaPessoas");

$iTT = new InterFaces(new Arquivos(Sistema::$layoutCaminhoDiretorio."login.html"));
$iTT->setSession($_SESSION);
$iTT->trocar("lang", $_SESSION['lang']);

if(!empty($_POST['email'])){
	
	$lP = new ListaPessoas;
	
	$cond[1] = array('campo' => ListaPessoas::EMAIL, 	'valor' => $_POST['email']);
	$cond[2] = array('campo' => ListaPessoas::SENHA, 	'valor' => $_POST['senha']);
	
	$lP->condicoes($cond);
	
	if($lP->getTotal() > 0){
		
		$p = $lP->listar();
		
		$l = new Lista('pessoas');
		$l->condicoes('', $p->getId(), 'id');
		$rs = $l->listar();
		
		if($p->getEmail()->getTotal() > 0)
			$rs['email'] = $p->getEmail()->listar()->email;
				
		$_SESSION['usuario'] = $rs;
		
		if(!empty($_SESSION['url']))
			header("Location: ".$_SESSION['url']);
		else
			header("Location: ".Sistema::$caminhoURL.$_SESSION['lang']."/usuario");
		
	}else
		$iTT->trocar('erro', $idioma->getTraducaoByConteudo("E-mail ou senha inválidos")->traducao);	
	
}

//include('lateral-esquerda.php');
//$iTT->trocar('lateralEsquerda', $lateralEsquerda);

$javaScript .= $iTT->createJavaScript()->concluir();
$includePagina = $iTT->concluir();

?>