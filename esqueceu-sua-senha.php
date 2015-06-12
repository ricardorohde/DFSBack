<?php

importar("TemTudoAqui.Usuarios.Lista.ListaPessoas");
importar("Utils.EnvioEmail");
importar("Utils.Dados.JSON");

if(!empty($_POST['email'])){
	
	$lP = new ListaPessoas;
	
	$cond[1] = array('campo' => ListaPessoas::EMAIL, 	'valor' => $_POST['email']);
	
	$lP->condicoes($cond);
	
	if($lP->getTotal() > 0){
		
		$p = $lP->listar();
		
		EnvioEmail::$para = $_POST['email'];
		EnvioEmail::$de = utf8_decode(Sistema::$nomeEmpresa)."<no-reply@motopecasaltoparana.com.br>";
		EnvioEmail::$assunto = utf8_decode($idioma->getTraducaoByConteudo("Resgate de senha")->traducao);
		EnvioEmail::$msg = utf8_decode("

Sua senha para acesso no site ".Sistema::$nomeEmpresa." é ".$p->senha.".

Atenciosamente,
Equipe ".Sistema::$nomeEmpresa."
");

		EnvioEmail::enviar();
		
		$rs['status'] = 'true';
		$rs['msg'] = $idioma->getTraducaoByConteudo("E-mail com sua senha enviado com sucesso")->traducao."!";	
		echo JSON::_Encode($rs);
		
	}else{
		$rs['status'] = 'false';
		$rs['msg'] = "E-mail ".$idioma->getTraducaoByConteudo("não cadastrado")->traducao."!";	
		echo JSON::_Encode($rs);
	}
	
	exit;
	
}

$iTT = new InterFaces(new Arquivos(Sistema::$layoutCaminhoDiretorio."esqueceu-sua-senha.html"));
$iTT->setSession($_SESSION);
$iTT->trocar("lang", $_SESSION['lang']);

$javaScript .= $iTT->createJavaScript()->concluir();
$includePagina = $iTT->concluir();

?>