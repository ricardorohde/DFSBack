<?php

importar("TemTudoAqui.Usuarios.Lista.ListaPessoas");
importar("Utils.Dados.Strings");
importar("Utils.EnvioEmail");
importar("JavaScript.Alertas.Aviso");

$_SESSION['url'] = Sistema::$caminhoURL.$_SESSION['lang']."/dados-cadastrais";

if(empty($_SESSION['usuario'])){
	header('Location: '.Sistema::$caminhoURL.$_SESSION['lang']."/login");
	exit;
}

$lP = new ListaPessoas;
$lP->condicoes('', $_SESSION['usuario']['id'], ListaPessoas::ID);
if($lP->getTotal() > 0){

	$p = $lP->listar();

	if(strtoupper($_GET['tipoAjax']) == 'CPF'){
		if(!Strings::__VerificarCPF($_GET['valor']) || $_GET['valor'] == '11111111111' || $_GET['valor'] == '22222222222' || $_GET['valor'] == '333333333333' || $_GET['valor'] == '44444444444' || $_GET['valor'] == '55555555555' || $_GET['valor'] == '66666666666' || $_GET['valor'] == '77777777777' || $_GET['valor'] == '88888888888' || $_GET['valor'] == '99999999999' || $_GET['valor'] == '00000000000'){
			$rs['status'] = "false";
			$rs['msg'] = 'CPF '.$idioma->getTraducaoByConteudo('inválido')->traducao.'!';
			echo JSON::_Encode($rs);
		}elseif(str_replace("-", "", str_replace(".", "", str_replace(" ", "", $_GET['valor']))) != $p->cpf){
			
			$lP = new ListaPessoas;
			$lP->condicoes('', str_replace("-", "", str_replace(".", "", str_replace(" ", "", $_GET['valor']))), ListaPessoas::CPF);
			if($lP->getTotal() > 0){
				$rs['status'] = "false";
				$rs['msg'] = 'CPF '.$idioma->getTraducaoByConteudo('já cadastrado')->traducao.'!';
				echo JSON::_Encode($rs);
			}else{
				$rs['status'] = "true";
				echo JSON::_Encode($rs);
			}
			
		}else{
			$rs['status'] = "true";
			echo JSON::_Encode($rs);
		}

		
		exit;
		
	}
	
	if(strtoupper($_GET['tipoAjax']) == 'CNPJ'){
		
		if(!Strings::__VerificarCNPJ($_GET['valor']) || $_GET['valor'] == '11111111111111' || $_GET['valor'] == '22222222222222' || $_GET['valor'] == '33333333333333' || $_GET['valor'] == '44444444444444' || $_GET['valor'] == '55555555555555' || $_GET['valor'] == '66666666666666' || $_GET['valor'] == '77777777777777' || $_GET['valor'] == '88888888888888' || $_GET['valor'] == '99999999999999' || $_GET['valor'] == '0000000000000'){
			$rs['status'] = "false";
			$rs['msg'] = 'CNPJ '.$idioma->getTraducaoByConteudo('inválido')->traducao.'!';
			echo JSON::_Encode($rs);
		}elseif(str_replace("-", "", str_replace(".", "", str_replace(" ", "", str_replace("/", "", $_GET['valor'])))) != $p->cnpj){
			
			$lP = new ListaPessoas;
			$lP->condicoes('', str_replace("-", "", str_replace(".", "", str_replace(" ", "", str_replace("/", "", $_GET['valor'])))), ListaPessoas::CNPJ);
			if($lP->getTotal() > 0){
				$rs['status'] = "false";
				$rs['msg'] = 'CNPJ '.$idioma->getTraducaoByConteudo('já cadastrado')->traducao.'!';
				echo JSON::_Encode($rs);
			}else{
				$rs['status'] = "true";
				echo JSON::_Encode($rs);
			}
			
		}else{
			$rs['status'] = "true";
			echo JSON::_Encode($rs);
		}

		
		exit;
		
	}
	
	if(strtoupper($_GET['tipoAjax']) == 'EMAIL'){
		
		if(!Strings::__VerificarEmail($_GET['valor'])){
			$rs['status'] = "false";
			$rs['msg'] = 'E-mail '.$idioma->getTraducaoByConteudo('inválido')->traducao.'!';
			echo JSON::_Encode($rs);
		}elseif($_GET['valor'] != $p->emailPrimario){
			
			$lE = new ListaEmails;
			$lE->condicoes('', $_GET['valor'], ListaEmails::EMAIL);
			if($lE->getTotal() > 0){
				$rs['status'] = "false";
				$rs['msg'] = 'E-mail '.$idioma->getTraducaoByConteudo('já cadastrado')->traducao.'!';
				echo JSON::_Encode($rs);
			}else{
				$rs['status'] = "true";
				echo JSON::_Encode($rs);
			}
		}else{
			$rs['status'] = "true";
			echo JSON::_Encode($rs);
		}
		
		exit;
		
	}
	
	$iTT = new InterFaces(new Arquivos(Sistema::$layoutCaminhoDiretorio."dados-cadastrais.html"));
	$iTT->setSession($_SESSION);
	$iTT->trocar("lang", $_SESSION['lang']);
	
	if(!empty($_POST)){
			
		$obrigatorio = $idioma->getTraducaoByConteudo('obrigatorio')->traducao;
		$jacadastrado = $idioma->getTraducaoByConteudo('já cadastrado')->traducao;
		$invalido = $idioma->getTraducaoByConteudo('inválido')->traducao;
		
		if(!empty($_POST['nome']) && !empty($_POST['cpf'])){
			if(empty($_POST['nome']) && empty($erro)){
				$erro = 'Nome é '.$obrigatorio;
			}
			if(empty($_POST['sobrenome']) && empty($erro)){
				$erro = 'Sobrenome é '.$obrigatorio;
			}
			if(empty($_POST['data-nasc']) && empty($erro)){
				$erro = 'Data de nascimento é '.$obrigatorio;
			}
			if(empty($_POST['cpf']) && empty($erro)){
				$erro = 'CPF é '.$obrigatorio;
			}elseif(!Strings::__VerificarCPF($_POST['cpf']) && empty($erro)){
				$erro = 'CPF '.$invalido;
			}elseif(empty($erro) && str_replace("-", "", str_replace(".", "", str_replace(" ", "", $_POST['cpf']))) != $p->cpf){
				$lP = new ListaPessoas;
				$lP->condicoes('', str_replace("-", "", str_replace(".", "", str_replace(" ", "", $_POST['cpf']))), ListaPessoas::CPF);
				if($lP->getTotal() > 0){
					$erro = 'CPF '.$jacadastrado;
				}
			}
		}else{
			if(empty($_POST['razao-social']) && empty($erro)){
				$erro = 'Razão Social é '.$obrigatorio;
			}
			if(empty($_POST['nome-fantasia']) && empty($erro)){
				$erro = 'Nome Fantasia é '.$obrigatorio;
			}
			if(empty($_POST['cnpj']) && empty($erro)){
				$erro = 'CNPJ é '.$obrigatorio;
			}elseif(!Strings::__VerificarCPF($_POST['cnpj']) && empty($erro)){
				$erro = 'CNPJ '.$invalido;
			}elseif(empty($erro) && str_replace("-", "", str_replace(".", "", str_replace(" ", "", $_POST['cnpj']))) != $p->cnpj){
				$lP = new ListaPessoas;
				$lP->condicoes('', str_replace("-", "", str_replace(".", "", str_replace(" ", "", $_POST['cnpj']))), ListaPessoas::CNPJ);
				if($lP->getTotal() > 0){
					$erro = 'CNPJ '.$jacadastrado;
				}
			}		
		}
		if(empty($_POST['telefone-p']) && empty($erro)){
			$erro = 'Telefone Principal é '.$obrigatorio;
		}
		if(empty($_POST['cep']) && empty($erro)){
			$erro = 'CEP é '.$obrigatorio;
		}
		if(empty($_POST['endereco']) && empty($erro)){
			$erro = 'Endereço é '.$obrigatorio;
		}
		if(empty($_POST['numero']) && empty($erro)){
			$erro = 'Número de endereço é '.$obrigatorio;
		}
		if(empty($_POST['bairro']) && empty($erro)){
			$erro = 'Bairro é '.$obrigatorio;
		}
		if(empty($_POST['cidade']) && empty($erro)){
			$erro = 'Cidade é '.$obrigatorio;
		}
		if(empty($_POST['estado']) && empty($erro)){
			$erro = 'Estado é '.$obrigatorio;
		}
		if(empty($_POST['email']) && empty($erro)){
			$erro = 'E-mail é '.$obrigatorio;
		}elseif(!Strings::__VerificarEmail($_POST['email']) && empty($erro)){
			$erro = 'E-mail '.$invalido;
		}elseif(empty($erro) && $_POST['email'] != $p->emailPrimario){
			$lE = new ListaEmails;
			$lE->condicoes('', $_POST['email'], ListaEmails::EMAIL);
			if($lE->getTotal() > 0){
				$erro = 'E-mail '.$jacadastrado;
			}
		}
		
		if(!empty($erro)){
			$iTT->trocar('erro', $erro);
			foreach($_POST as $k => $v)
				$iTT->trocar($k, $v);				
		}else{
		
			if($p instanceof PessoaFisica){
				$p->setDataNasc(new DataHora($_POST['data-nasc']));
				$p->rg = $_POST['rg'];
				$p->cpf = str_replace("-", "", str_replace(".", "", str_replace(" ", "", $_POST['cpf'])));
				$p->nome = $_POST['nome'];
				$p->sobreNome = $_POST['sobrenome'];
			}else{
				$p->razaoSocial = $_POST['razao-social'];
				$p->cnpj = str_replace("-", "", str_replace(".", "", str_replace(" ", "", str_replace("/", "", $_POST['cnpj']))));
				$p->nome = $_POST['nome-fantasia'];
			}
			
			if(!empty($_POST['senha']))
				$p->senha = $_POST['senha'];
			
			$p->emailPrimario = $_POST['email'];
			
			$lP->alterar($p);
			
			$end = $p->getEndereco()->listar();
			$end->logradouro = $_POST['endereco'];
			$end->numero = $_POST['numero'];
			$end->complemento = $_POST['complemento'];
			$end->bairro = $_POST['bairro'];
			$end->setPais(new Pais(1));
			
			$lE = new ListaEstados;
			$lE->condicoes('', strtoupper($_POST['estado']), ListaEstados::UF);
			if($lE->getTotal() > 0)
				$end->setEstado($lE->listar());
			else{
				$end->getEstado()->uf = $_POST['estado'];
				$end->getEstado()->setPais($end->getPais());
			}
			$end->getCidade()->nome = $_POST['cidade'];
			$end->getCidade()->setPais($end->getPais());
			$end->getCidade()->setEstado($end->getEstado());
			$end->setCep($_POST['cep']);
			$end->loadCep();
			
			$p->getEndereco()->alterar($end);
			
			$tel = $p->getTelefone()->listar();
			$tel->local = 'Telefone Principal';
			$telefone = str_replace("-", "", str_replace("(", "", str_replace(")", "", str_replace(" ", "", $_POST['telefone-p']))));
			$tel->ddd = substr($telefone, 0, 2);
			$tel->telefone = substr($telefone, 2, 9);
			$p->getTelefone()->alterar($tel);
			
			$celular = str_replace("-", "", str_replace("(", "", str_replace(")", "", str_replace(" ", "", $_POST['celular']))));
			if(!empty($celular)){
				$tel2 = $p->getTelefone()->listar();
				$tel2->local = 'Celular';
				$tel2->ddd = substr($celular, 0, 2);
				$tel2->telefone = substr($celular, 2, 9);
				$p->getTelefone()->alterar($tel2);
			}
			
			$et = explode("Ramal:", $_POST['telefone-c']);
			$telefonec = str_replace("-", "", str_replace("(", "", str_replace(")", "", str_replace(" ", "", $et[0]))));
			if(!empty($telefonec)){
				$tel3 = $p->getTelefone()->listar();
				$tel3->local = 'Telefone Comercial';
				$tel3->ddd = substr($telefonec, 0, 2);
				$tel3->telefone = substr($telefonec, 2, 9);
				$tel3->ramal = $et[1];
				$p->getTelefone()->alterar($tel3);
			}
			
			$email = $p->getEmail()->listar();
			$email->email = $_POST['email'];
			$p->getEmail()->alterar($email);
			
			$iTT->trocar('msg', $idioma->getTraducaoByConteudo('Alteração realizada com sucesso')->traducao);
		
		}
		
	}
		
	if($p instanceof PessoaFisica)
		$iTT->trocar('nome', 		$p->nome);
	else
		$iTT->trocar('nome-fantasia',	$p->nome);
		
	$iTT->trocar('sobrenome', 	$p->sobreNome);
	$iTT->trocar('razao-social', $p->razaoSocial);
	if($p->getDataNasc())
	$iTT->trocar('data-nasc', 	$p->getDataNasc()->mostrar());
	
	$iTT->trocar('rg', 			$p->rg);
	$iTT->trocar('cpf', 		$p->cpf);
	$iTT->trocar('cnpj', 		$p->cnpj);
	
	$end = $p->getEndereco()->setParametros(0)->listar();	
	$iTT->trocar('estado', 		$end->getEstado()->uf);
	$iTT->trocar('cidade', 		$end->getCidade()->nome);
	$iTT->trocar('endereco', 	$end->logradouro);
	$iTT->trocar('numero',	 	$end->numero);
	$iTT->trocar('complemento', $end->complemento);
	$iTT->trocar('bairro',	 	$end->bairro);
	$iTT->trocar('cep',		 	$end->getCep());
	
	$tel = $p->getTelefone()->setParametros(0)->listar();
	$iTT->trocar('telefone-p',	"(".$tel->ddd.") ".$tel->telefone);
	$tel = $p->getTelefone()->listar();
	if(!empty($tel))
		$iTT->trocar('celular', 	"(".$tel->ddd.") ".$tel->telefone);
	$tel = $p->getTelefone()->listar();
	if(!empty($tel))
		$iTT->trocar('telefone-c', 	"(".$tel->ddd.") ".$tel->telefone." Ramal: ".$tel->ramal);
	
	$email = $p->getEmail()->listar();
	$iTT->trocar('email', 	$email->email);	
	
}

include('lateral-esquerda.php');
$iTT->trocar('lateralEsquerda', $lateralEsquerda);

$javaScript .= $iTT->createJavaScript()->concluir();

$includePagina = $iTT->concluir();

?>