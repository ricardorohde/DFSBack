<?php

importar("TemTudoAqui.Usuarios.Lista.ListaPessoas");
importar("Utilidades.Publicidades.Mailing.Lista.ListaPacoteMailings");
importar("Utils.Dados.Strings");
importar("Utils.EnvioEmail");
importar("JavaScript.Alertas.Aviso");

$iTT = new InterFaces(new Arquivos(Sistema::$layoutCaminhoDiretorio."cadastro.html"));
$iTT->setSession($_SESSION);
$iTT->trocar("lang", $_SESSION['lang']);

if(strtoupper($_GET['tipoAjax']) == 'EMAIL'){
	
	if(!Strings::__VerificarEmail($_GET['valor'])){
		$rs['status'] = "false";
		$rs['msg'] = 'E-mail '.$idioma->getTraducaoByConteudo('inválido')->traducao.'!';
		echo JSON::_Encode($rs);
	}else{
		
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
	}
	
	exit;
	
}

if(!empty($_POST)){
	
	$obrigatorio = $idioma->getTraducaoByConteudo('obrigatorio')->traducao;
	$jacadastrado = $idioma->getTraducaoByConteudo('já cadastrado')->traducao;
	$invalido = $idioma->getTraducaoByConteudo('inválido')->traducao;

	if(empty($_POST['nome']) && empty($erro)){
		$erro = 'Nome é '.$obrigatorio;
	}
	if(empty($_POST['sobrenome']) && empty($erro)){
		$erro = 'Sobrenome é '.$obrigatorio;
	}
	if(empty($_POST['data-nasc']) && empty($erro)){
		$erro = 'Data de nascimento é '.$obrigatorio;
	}
	if(empty($_POST['telefone-p']) && empty($erro)){
		$erro = 'Telefone Principal é '.$obrigatorio;
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
	if(empty($_POST['pais']) && empty($erro)){
		$erro = 'Pais é '.$obrigatorio;
	}
	if(empty($_POST['email']) && empty($erro)){
		$erro = 'E-mail é '.$obrigatorio;
	}elseif(!Strings::__VerificarEmail($_POST['email']) && empty($erro)){
		$erro = 'E-mail '.$invalido;
	}elseif(empty($erro)){
		$lE = new ListaEmails;
		$lE->condicoes('', $_POST['email'], ListaEmails::EMAIL);
		if($lE->getTotal() > 0){
			$erro = 'E-mail '.$jacadastrado;
		}
	}
	if(empty($_POST['senha']) && empty($erro)){
		$erro = 'Senha é '.$obrigatorio;
	}
	
	if(!empty($erro)){
		$iTT->trocar('erro', $erro);
		foreach($_POST as $k => $v)
			$iTT->trocar($k, $v);
	}else{
	
		$lP = new ListaPessoas;
		$p = new PessoaFisica;
		$p->setDataNasc(new DataHora($_POST['data-nasc']));
		$p->rg = $_POST['rg'];
		$p->nome = $_POST['nome'];
		$p->sobreNome = $_POST['sobrenome'];
		
		$p->senha = $_POST['senha'];
		$p->emailPrimario = $_POST['email'];
		
		$lP->inserir($p);
		
		$end = new Endereco;
		$end->logradouro = $_POST['endereco'];
		$end->numero = $_POST['numero'];
		$end->complemento = $_POST['complemento'];
		$end->bairro = $_POST['bairro'];
		$end->setPais(new Pais($_POST['pais']));
		
		$lE = new ListaEstados;
		$lE->condicoes('', strtoupper($_POST['estado']), "UPPER(".ListaEstados::NOME.")");
		if($lE->getTotal() > 0)
			$end->setEstado($lE->listar());
		else{
			$end->getEstado()->nome = $_POST['estado'];
			$end->getEstado()->setPais($end->getPais());
		}
		$lC = new ListaCidades;
		$lC->condicoes('', strtoupper($_POST['cidade']), "UPPER(".ListaCidades::NOME.")");
		if($lC->getTotal() > 0)
			$end->setCidade($lC->listar());
		else{
			$end->setCidade(new Cidade);
			$end->getCidade()->nome = $_POST['cidade'];
			$end->getCidade()->setEstado($end->getEstado());
			$end->getCidade()->setPais($end->getPais());
		}
		
		$p->addEndereco($end);
		
		$tel = new Telefone;
		$tel->local = 'Telefone Principal';
		$telefone = str_replace("-", "", str_replace("(", "", str_replace(")", "", str_replace(" ", "", $_POST['telefone-p']))));
		//$tel->ddd = substr($telefone, 0, 2);
		$tel->telefone = $_POST['telefone-p'];
		$p->addTelefone($tel);
		
		$celular = str_replace("-", "", str_replace("(", "", str_replace(")", "", str_replace(" ", "", $_POST['celular']))));
		if(!empty($celular)){
			$tel2 = new Telefone;
			$tel2->local = 'Celular';
			//$tel2->ddd = substr($celular, 0, 2);
			$tel2->telefone = $_POST['celular'];
			$p->addTelefone($tel2);
		}
		
		$et = explode("Ramal:", $_POST['telefone-c']);
		$telefonec = str_replace("-", "", str_replace("(", "", str_replace(")", "", str_replace(" ", "", $et[0]))));
		if(!empty($telefonec)){
			$tel3 = new Telefone;
			$tel3->local = 'Telefone Comercial';
			//$tel3->ddd = substr($telefonec, 0, 2);
			$tel3->telefone = $_POST['telefone-c'];
			//$tel3->ramal = $et[1];
			$p->addTelefone($tel3);
		}
		
		$email = new Email;
		$email->email = $_POST['email'];
		$p->addEmail($email);
		
		EnvioEmail::$para = $_POST['email'];
		EnvioEmail::$de = Sistema::$nomeEmpresa."<noreply@>";
		EnvioEmail::$assunto = $idioma->getTraducaoByConteudo("Cadastro realizado com sucesso")->traducao."!";
		EnvioEmail::$msg = "

".$idioma->getTraducaoByConteudo("Desde já agradecemos por seu cadastro. Abaixo os dados de seu cadastro")->traducao.":";


	EnvioEmail::$msg .= "
".$idioma->getTraducaoByConteudo("Nome")->traducao.": ".$p->nome."
".$idioma->getTraducaoByConteudo("Sobrenome")->traducao.": ".$p->sobreNome."
".$idioma->getTraducaoByConteudo("Data de Nascimento")->traducao.": ".$p->getDataNasc()->mostrar()."

------------------------------------------------------------------------------

".$idioma->getTraducaoByConteudo("R.G.")->traducao.": ".$p->rg;

EnvioEmail::$msg .= "
".$idioma->getTraducaoByConteudo("Cidade")->traducao.": ".$end->getCidade()->nome." - ".strtoupper($end->getEstado()->nome)." - ".strtoupper($end->getPais()->nome)."
".$idioma->getTraducaoByConteudo("Endereço")->traducao.": ".$end->logradouro."
".$idioma->getTraducaoByConteudo("Número")->traducao.": ".$end->numero."
".$idioma->getTraducaoByConteudo("Complemento:")->traducao." ".$end->complemento."
".$idioma->getTraducaoByConteudo("Bairro")->traducao.": ".$end->bairro."
-----------------------------------------------------------------------------

".$idioma->getTraducaoByConteudo("Telefone Principal")->traducao.": ".$tel->telefone.(!empty($tel2) ? "
".$idioma->getTraducaoByConteudo("Celular")->traducao.": ".$tel2->telefone : '').(!empty($tel3) ? "
".$idioma->getTraducaoByConteudo("Telefone Comercial")->traducao.": ".$tel3->telefone : '')."
----------------------------------------------------------------------------

".$idioma->getTraducaoByConteudo("Senha")->traducao.": ".$p->senha."


".$idioma->getTraducaoByConteudo("Atenciosamente")->traducao.",
".(Sistema::$nomeEmpresa)."
";

		EnvioEmail::enviar();
		
		$l = new Lista('pessoas');
		$l->condicoes('', $p->getId(), 'id');
		if($l->getTotal() > 0){
			$rs = $l->listar();
		
			if($p->getEmail()->getTotal() > 0)
				$rs['email'] = $p->getEmail()->listar()->email;
				
			$_SESSION['usuario'] = $rs;
			
			$lPM = new ListaPacoteMailings;
			$lPM->condicoes('', 1, ListaPacoteMailings::ID);
			if($lPM->getTotal() > 0){
				
				$pM = $lPM->listar();
				try{
					$pM->addEmail($_POST['email'], $p->nome, $end->getCidade()->getId(), $end->getEstado()->getId(), '', $p->getDataNasc());
				}catch(Exception $e){}
			}
		}
		
		if(!empty($_SESSION['url']))
			header("Location: ".$_SESSION['url']);
		else
			header("Location: ".Sistema::$caminhoURL.$_SESSION['lang']);
			
	}
	
	
}

$lPA = new ListaPaises;
$iTT->createRepeticao("repetir->Paises");
while($pa = $lPA->listar("ASC", ListaPaises::ID)){
	$iTT->repetir();
	$iTT->enterRepeticao()->trocar('id.Pais', $pa->getId());
	$iTT->enterRepeticao()->trocar('nome.Pais', $pa->nome);
}
//include('lateral-esquerda.php');
//$iTT->trocar('lateralEsquerda', $lateralEsquerda);

$javaScript .= $iTT->createJavaScript()->concluir();

$includePagina = $iTT->concluir();

?>