<?php

importar("Utilidades.UploadsDownloads.Lista.ListaUploadDownloadArquivos");
importar("LojaVirtual.Produtos.Lista.ListaProdutos");
importar("Utilidades.Lista.ListaRecados");
importar("JavaScript.Alertas.Aviso");
importar("Utils.EnvioEmail");
importar("Utils.Dados.Arrays");
importar("Utils.Dados.Strings");

$_SESSION['url'] = $url;

$con = BDConexao::__Abrir();
$con->executar("SELECT * FROM ".Sistema::$BDPrefixo."pagamentos");
$rsP = $con->getRegistro();

//Categoria
$lPC = new ListaProdutoCategorias;
if(!empty($_GET['idcategoria']))
	$lPC->condicoes('', $_GET['idcategoria'], ListaProdutoCategorias::ID);
elseif(!empty($procura)){

	$lU = new ListaURLs;

	$cond[1] = array('campo' => ListaURLs::URL, 	'valor' => $procura);
	$cond[2] = array('campo' => ListaURLs::TABELA, 	'valor' => $lPC->getTabela());

	if($lU->condicoes($cond)->getTotal() > 0){
		$lPC->condicoes('', $lU->listar()->valor, ListaProdutoCategorias::ID);	
	}

}

if($lPC->getTotal() > 0)
	$pCP 	= $lPC->listar();
else
	$pCP 	= new ProdutoCategoria;

//if($pCP->getIdCategoriaPai() == '1010101001'){
//	$lPC->condicoes('', $pCP->getIdCategoriaPai(), ListaProdutoCategorias::ID);
//	$pCP 	= $lPC->listar();
//}

$pCP->setSession($_SESSION);

$nav 	= $pCP->getNavegador(new Templates(Arquivos::__Create("<li><a href='".Sistema::$caminhoURL.$_SESSION['lang'].'/'.$pagina.'/{url}'."'>{nome}</a></li>")), "");

//

//Produto

$lP = new ListaProdutos;
if(!empty($_GET['idproduto']))
	$lP->condicoes('', $_GET['idproduto'], ListaProdutos::ID);
elseif(!empty($procura2)){

	$lU = new ListaURLs;

	$cond[1] = array('campo' => ListaURLs::URL, 	'valor' => $procura2);
	$cond[2] = array('campo' => ListaURLs::TABELA, 	'valor' => $lP->getTabela());

	if($lU->condicoes($cond)->getTotal() > 0){
		$lP->condicoes('', $lU->listar()->valor, ListaProdutos::ID);	
	}

}

if($lP->getTotal() > 0){
	$p = $lP->listar();
	if(!$p->disponivel){
		header("Location: ".Sistema::$caminhoURL.$_SESSION['lang']);
		exit;
	}
}else{
	header("Location: ".Sistema::$caminhoURL.$_SESSION['lang']);
	exit;
}

setcookie('favoritos['.count($_COOKIE['favoritos']).']', $p->getId(), time()*10, "/");

$estoque = $p->estoque;
while($pI = $p->getInfos()->listar()){
	$estoque += $pI->estoque;
}
$p->getInfos()->setParametros(0);

$iTDT = new InterFaces(new Arquivos(Sistema::$layoutCaminhoDiretorio."detalhes.html"));
	
$iTDT->setSESSION($_SESSION);
$iTDT->trocar('lang', $_SESSION['lang']);
$iTDT->trocar('urlSite', $url);

$iTDT->trocar('navegador.ProdutoCategoria', !empty($nav) ? "<li><a href='".Sistema::$caminhoURL.$_SESSION['lang'].'/'.$pagina."'>".$idioma->getTraducaoByConteudo('Produtos')->traducao."</a>".'</li> '.$nav : "<li class='ativo'>".$idioma->getTraducaoByConteudo('Produtos')->traducao."</li>");
$iTDT->condicao('condicao->ProdutoCategorias', $pCP->getSubCategorias()->getTotal() > 0);

if(!empty($pCP->nome))
	$iTDT->trocar('traduzir->Produtos', $idioma->getTraducaoByConteudo($pCP->nome)->traducao);

//

include('lateral-esquerda.php');
$iTDT->trocar('lateralEsquerda', $lateralEsquerda);

//Ações
if(!empty($_POST)){
		
	if(!empty($_POST['emailEncomenda'])){
		if(Strings::__VerificarEmail($_POST['emailEncomenda'])){
				
			$lP->condicoes('', $_POST['idproduto'], ListaProdutos::ID);
			if($lP->getTotal() > 0){
				$pE = $lP->listar();
				$pE->addEncomenda($_POST['emailEncomenda']);
				echo JSON::_Encode(array('msg' => $idioma->getTraducaoByConteudo('Obrigado pela sua participação')->traducao."!"));
				exit;
			}
			
		}
	}
	
	if(!empty($_POST['emailConsulta'])){
		if(Strings::__VerificarEmail($_POST['emailConsulta'])){
			$lP->condicoes('', $_POST['idproduto'], ListaProdutos::ID);
			if($lP->getTotal() > 0){
			
				$pE = $lP->listar();
				
				$temE = new InterFaces(new Arquivos(Sistema::$adminLayoutCaminhoDiretorio."/email-padrao.html"));
				$temEE = new InterFaces(new Arquivos(Sistema::$adminLayoutCaminhoDiretorio."/SistemaProdutos/email-sob-consulta.html"));
				
				if($pE->getImagens()->getTotal() > 0){
					$img = $pE->getImagens()->listar("DESC", ListaImagens::DESTAQUE);
					if($img->getImage()->nome != '')
						$temEE->trocar('imagem', $img->getImage()->showHTML(170, 170));
					$pE->getImagens()->setParametros(0);
				}
				$temEE->trocar('nome', $pE->nome);
				$temEE->trocar('codigo', $pE->codigo);
				if($pE->getMarca())
					$temEE->trocar('nome.Marca', $pE->getMarca()->nome);
				
				if($pE->getCategorias()->getTotal() > 0)
					$temEE->trocar('linkVisualizar', Sistema::$caminhoURL.$_SESSION['lang']."/produtos/".$pE->getCategorias()->listar()->getURL()->url."/".$pE->getURL()->url);
				else
					$temEE->trocar('linkVisualizar', Sistema::$caminhoURL.$_SESSION['lang']."/produtos/".$pE->getMarca()->getURL()->url."/".$pE->getURL()->url);
				
				$temE->trocar('texto', $temEE->concluir());
				$msg = $temE->concluir();
				
				EnvioEmail::$de = (!empty($_SESSION['usuario']) ? $_SESSION['usuario']['nome'] : $idioma->getTraducaoByConteudo('Usuário Anônimo')->traducao)."<".$_POST['emailConsulta'].">";
				EnvioEmail::$assunto = $idioma->getTraducaoByConteudo('Pedido de orçamento')->traducao;
				EnvioEmail::$html = true;
				EnvioEmail::$msg = $msg;
				EnvioEmail::$para = Sistema::$emailEmpresa;
				EnvioEmail::enviar();
				
				echo JSON::_Encode(array('msg' => $idioma->getTraducaoByConteudo('Pedido de Orçamento enviado com sucesso')->traducao."!"));
				exit;
				
			}
		}		
	}
	
	if(!empty($_POST['nomeAmigo'])){
		
		$temE = new InterFaces(new Arquivos(Sistema::$adminLayoutCaminhoDiretorio."/email-padrao.html"));
		$temEE = new InterFaces(new Arquivos(Sistema::$adminLayoutCaminhoDiretorio."/SistemaProdutos/email-indicar.html"));
		$temEE->setSession($_SESSION);
		
		if($p->getImagens()->getTotal() > 0){
			$img = $p->getImagens()->listar("DESC", ListaImagens::DESTAQUE);
			if($img->getImage()->nome != '')
				$temEE->trocar('imagem', $img->getImage()->showHTML(170, 170));
			$p->getImagens()->setParametros(0);
		}
		$temEE->trocar('nomeamigo', $_POST['nomeAmigo']);
		$temEE->trocar('seunome', $_POST['nome']);
		$temEE->trocar('mensagem', $_POST['mensagem']);
		$temEE->trocar('nome', $p->nome);
		$temEE->trocar('codigo', $p->codigo);
		if($p->getMarca())
			$temEE->trocar('nome.Marca', $p->getMarca()->nome);
		
		if($p->getCategorias()->getTotal() > 0)
			$temEE->trocar('linkVisualizar', Sistema::$caminhoURL.$_SESSION['lang']."/produtos/".$p->getCategorias()->listar()->getURL()->url."/".$p->getURL()->url);
		else
			$temEE->trocar('linkVisualizar', Sistema::$caminhoURL.$_SESSION['lang']."/produtos/".$p->getMarca()->getURL()->url."/".$p->getURL()->url);
		
		$temE->trocar('texto', $temEE->concluir());
		$msg = $temE->concluir();
		
		EnvioEmail::$de = Sistema::$nomeEmpresa."<".Sistema::$emailEmpresa.">";
		EnvioEmail::$assunto = $_POST['nome'].' '.$idioma->getTraducaoByConteudo('indicou um produto para você')->traducao."!";
		EnvioEmail::$html = true;
		EnvioEmail::$msg = $msg;
		EnvioEmail::$para = $_POST['emailAmigo'];
		EnvioEmail::enviar();
		
		$cond['msg'] = $idioma->getTraducaoByConteudo('E-mail de indicação enviado com sucesso')->traducao."!";
		echo JSON::_Encode($cond);
		exit;
		
	}

	if(!empty($_POST['titulo-opiniao'])){
		
		$lPS = new ListaPessoas;
		$lPS->condicoes('', $_SESSION['usuario']['id'], ListaPessoas::ID);
		
		if($lPS->getTotal() > 0)
			$pS = $lPS->listar();
		else{
			$pS = new PessoaFisica;
			$pS->nome = $_POST['nome-opiniao'];
		}
		
		$end = $pS->getEndereco()->listar();
		
		$r = new Recado;
		$r->setSessao('produtos', $p->getId());
		
		$r->nome = empty($_POST['nome-opiniao']) ? $pS->nome : $_POST['nome-opiniao'];
		$r->email = $pS->emailPrimario;
		$r->local = $end->cidade.", ".$end->estado;
		$r->getTexto()->titulo = $_POST['titulo-opiniao'];
		$r->getTexto()->texto = $_POST['mensagem-opiniao'];
		
		$lR = new ListaRecados;
		$lR->inserir($r);
		
		echo JSON::_Encode(array('msg' => $idioma->getTraducaoByConteudo('Obrigado pela sua participação')->traducao."!"));
		exit;
		
	}
	
}

$iTDT->condicao('condicao->Ecommerce', $rsP['tiposite'] == 2);
$iTDT->condicao('condicao->PedidoComVenda', $rsP['tiposite'] == 1 || ($rsP['tiposite'] == 2 && $rsP['tipopedido'] != 1));

if($p->tipoPedido == Produto::TIPO_PEDIDO_SOB_CONSULTA || $rsP['tipopedidoprodutostodosite'] == 1){
	$p->valorReal = 0;
}

//Informações do Produto Pai

$iTDT->condicao("condicao->Usuario", !empty($_SESSION['usuario']));
$iTDT->condicao("condicao->Recados", $rsP['tiposite'] == 1 || !empty($_SESSION['usuario']));

$iTDT->trocar('url', 				$p->getURL()->url);
$iTDT->trocar('id', 				$p->getId());
$iTDT->trocar('nome', 				addslashes($idioma->getTraducaoByConteudo($p->nome)->traducao));
$iTDT->trocar('codigo',				$p->codigo);
$iTDT->trocar('id.Marca',			$p->getMarca()->getId());
$iTDT->trocar('nome.Marca',			addslashes($p->getMarca()->nome));
$iTDT->trocar('url.Imagem.Marca',	$p->getMarca()->getImagem()->pathImage(100, 100));
$iTDT->trocar('moeda',				'U$');
$iTDT->condicao('condicao->Promocao', $p->valorVenda->num < $p->valorReal->num && $p->valorVenda->num > 0);
$iTDT->trocar('valor.ValorReal',	$p->valorReal->formatar());
$iTDT->trocar('moeda.ValorReal',	$p->valorReal->moeda());
$iTDT->trocar('valor.ValorVenda',	$p->valorVenda->formatar());
$iTDT->trocar('moeda.ValorVenda',	$p->valorVenda->moeda());

$iTDT->trocar('estoque',			$p->estoque);
$iTDT->trocar('peso',				$p->peso->formatar());
$iTDT->trocar('altura',				$p->altura->formatar());
$iTDT->trocar('largura',			$p->largura->formatar());
$iTDT->trocar('comprimento',		$p->comprimento->formatar());
$iTDT->trocar('formato',			1);
$iTDT->trocar('tipoUnidade',		$idioma->getTraducaoByConteudo($p->tipoUnidade)->traducao);
$iTDT->trocar('quantidade',			$p->quantidadeu > 0 ? 1 : '');
$iTDT->trocar('descricaoP',			$idioma->getTraducaoByConteudo($p->descricaoPequena)->traducao);
$iTDT->trocar('descricao', 			$idioma->getTraducaoByConteudo($p->descricao)->traducao);
$iTDT->trocar('descricaoPSimples',	strip_tags($idioma->getTraducaoByConteudo($p->descricaoPequena)->traducao));
$iTDT->trocar('descricaoSimples', 	strip_tags($idioma->getTraducaoByConteudo($p->descricao)->traducao));
$iTDT->trocar('linkPedido', 		Sistema::$caminhoURL.$_SESSION['lang']."/processar-carrinho");

$iTDT->condicao('condicao->Video', $p->getVideo());
if($p->getVideo()!= '')
	$iTDT->trocar('video', 			$p->getVideo());

$iTDT->condicao('condicao->PedidoOrcamento', $rsP['tipopedidoprodutostodosite'] == Produto::TIPO_PEDIDO_SOB_CONSULTA || $p->tipoPedido == Produto::TIPO_PEDIDO_SOB_CONSULTA);
$iTDT->condicao('condicao->PedidoSemVenda', $rsP['tipopedido'] == 1);

//Catálogos
$lUDA = new ListaUploadDownloadArquivos;
unset($aRU);
$aRU[1] = array("campo" => ListaUploadDownloadArquivos::PRODUTOS, "valor" => "(.*) ".$p->codigo." (.*)",  "operador" => "REGEXP");
$aRU[2] = array("campo" => ListaUploadDownloadArquivos::PRODUTOS, "valor" => "^".$p->codigo." (.*)",  "operador" => "REGEXP", 'OR' => true);
$lUDA->condicoes($aRU);
$iTDT->createRepeticao("repetir->UploadDownloadArquivos");
while($uDA = $lUDA->listar("ASC", ListaUploadDownloadArquivos::ORDEM)){
	$iTDT->repetir();
	$iTDT->enterRepeticao()->trocar("nome.UploadDownloadArquivo", $uDA->getArquivo()->nome);
	$iTDT->enterRepeticao()->trocar("url.UploadDownloadArquivo", Sistema::$caminhoURL.Sistema::$caminhoDataUploadsDownloads.$uDA->getArquivo()->nome.".".$uDA->getArquivo()->extensao);
}	
//

//metatag
$titulo = $p->nome;
$descricao = $p->descricao;
//

$arrayOpcoes = array();
$idOpcoes = '';
$iTDT->createRepeticao('repetir->ProdutoOpcoes');
if($p->getOpcoes()->getTotal() > 0){
	while($pOG = $p->getOpcoes()->listar('ASC', ListaProdutoOpcaoGerados::OPCAO)){
		
		$idOpcoes .= $pOG->getValor()->getId();
		$arrayOpcoes[$pOG->getOpcao()->getId()][] = array('id' => $pOG->getValor()->getId(), 'valor' => $pOG->getValor()->valor, 'cor' => $pOG->getValor()->cor, 'image' => ($pOG->getValor()->getImage()->nome != '') ? $pOG->getValor()->getImage()->nome.".".$pOG->getValor()->getImage()->extensao : '');
		
		if($pOG->getOpcao()->aberto && $pOG->getOpcao()->multi){
			
			$iTDT->repetir();
			$iTDT->enterRepeticao()->trocar('id.ProdutoOpcao', $pOG->getOpcao()->getId());
			$iTDT->enterRepeticao()->trocar('id.ProdutoOpcaoValor.ProdutoOpcao', $pOG->getValor()->getId());
			$iTDT->enterRepeticao()->trocar('valor.ProdutoOpcaoValor.ProdutoOpcao', addslashes($pOG->getValor()->valor));
			$iTDT->enterRepeticao()->trocar('cor.ProdutoOpcaoValor.ProdutoOpcao', $pOG->getValor()->cor);
		
		}
		
	}
}else{
	
		
	$idOpcoes .= "0";
	
	$iTDT->repetir();
	$iTDT->enterRepeticao()->trocar('id.ProdutoOpcao', "0");
	
	
}

foreach($iTDT->getRepeticoes('repetir->ProdutoOpcoes') as $k => $t)
	if(is_int($k))
		$t->trocar('id.Opcoes', $idOpcoes);
	
$iTDT->trocar('id.Opcoes', $idOpcoes);

$parcelas = Pedido::__ParcelasPagSeguro($p->valor->num);
$iTDT->createRepeticao("repetir->PagSeguro");
foreach($parcelas as $k => $v){
	$iTDT->repetir();
	$iTDT->enterRepeticao()->trocar('parcela.PagSeguro', $k);
	$iTDT->enterRepeticao()->trocar('valor.parcela.PagSeguro', Numero::__CreateNumero($v)->moeda());
	$iTDT->condicao('condicao->Parcela'.$k.'.pagSeguro.valor.Produto',  $v > PagamentoPagSeguro::PARCELAMINIMA && $rsP['ativopagseguro']);
	$iTDT->trocar('parcela'.$k.'.pagSeguro.valor',  Numero::__CreateNumero($v)->moeda());
}

$iTDT->createRepeticao("repetir->Imagens");
$iTDT->condicao("condicao->Imagens", true);
if($p->getImagens()->getTotal() > 0){

	$img = $p->getImagens()->listar("DESC", ListaImagens::DESTAQUE);
	$iTDT->trocar('imagem', $img->getImage()->pathImage(500, 500));
	$iTDT->trocar('url.Imagem', $img->getImage()->pathImage(1200, 800));

	//metatag
	$imagem = $img->getImage()->pathImage(800, 600);
	//

	$p->getImagens()->setParametros(0);
	while($img = $p->getImagens()->listar("DESC", ListaImagens::DESTAQUE)){

		$iTDT->repetir();
		$iTDT->enterRepeticao()->trocar('posicao.Imagem', $p->getImagens()->getParametros());
		$iTDT->enterRepeticao()->trocar('url.Imagem', $img->getImage()->pathImage(1200, 800));
		$iTDT->enterRepeticao()->trocar('url.medium.Imagem', $img->getImage()->pathImage(350, 272));
		$iTDT->enterRepeticao()->trocar('url.thumb.Imagem', $img->getImage()->pathImage(150, 120));

	}

}else{
	$iTDT->trocar('imagem', '<img src="'.Sistema::$caminhoURL.'lib.img/sem-imagem.gif" />');
	$iTDT->trocar('url.Imagem', Sistema::$caminhoURL.'lib.img/sem-imagem.gif');
	$iTDT->repetir();
	$iTDT->enterRepeticao()->trocar('posicao.Imagem', 1);
	$iTDT->enterRepeticao()->trocar('url.Imagem', Sistema::$caminhoURL.'lib.img/sem-imagem.gif');
	$iTDT->enterRepeticao()->trocar('url.medium.Imagem', Sistema::$caminhoURL.'lib.img/sem-imagem.gif');
	$iTDT->enterRepeticao()->trocar('url.thumb.Imagem', Sistema::$caminhoURL.'lib.img/sem-imagem.gif');
}

//

//Variações
$repeticaoVariacoes = 'repetir->Variacoes';
$iTDT->createRepeticao($repeticaoVariacoes);
if($p->getProdutoPai() > 0){
	$lP->condicoes('', '', '', '', "SELECT * FROM ".Sistema::$BDPrefixo."produtos WHERE id <> '".$p->getId()."' AND (id = '".$p->getProdutoPai()."' OR produtopai = '".$p->getProdutoPai()."')");
	if($lP->getTotal() > 0){
		$lPO = $lP;
	}
}else
	$lPO = $p->getInfos();

while($pI = $lPO->listar()){
	
	//Informações das variações
	
	if($p->tipoPedido == Produto::TIPO_PEDIDO_SOB_CONSULTA || $pI->tipoPedido == Produto::TIPO_PEDIDO_SOB_CONSULTA || $rsP['tipopedidoprodutostodosite'] == 1){
		$pI->valorReal = 0;
	}
	
	$iTDT->repetir($repeticaoVariacoes);
	
	$iTDT->enterRepeticao($repeticaoVariacoes)->trocar('url.Variacao', 					$pI->getURL()->url);
	$iTDT->enterRepeticao($repeticaoVariacoes)->trocar('id.Variacao', 					$pI->getId());
	$iTDT->enterRepeticao($repeticaoVariacoes)->trocar('nome.Variacao', 				addslashes($idioma->getTraducaoByConteudo($pI->nome)->traducao));
	$iTDT->enterRepeticao($repeticaoVariacoes)->trocar('codigo.Variacao',				$pI->codigo);
	$iTDT->enterRepeticao($repeticaoVariacoes)->trocar('id.Marca.Variacao',				$pI->getMarca()->getId());
	$iTDT->enterRepeticao($repeticaoVariacoes)->trocar('nome.Marca.Variacao',			addslashes($pI->getMarca()->nome));
	$iTDT->enterRepeticao($repeticaoVariacoes)->trocar('url.Imagem.Marca.Variacao',		$pI->getMarca()->getImagem()->pathImage(100, 100));
	$iTDT->enterRepeticao($repeticaoVariacoes)->trocar('moeda.Variacao',				'U$');
	$iTDT->enterRepeticao($repeticaoVariacoes)->trocar('valor.ValorReal.Variacao',		$pI->valorReal->num ? $pI->valorReal->formatar() : 0);
	$iTDT->enterRepeticao($repeticaoVariacoes)->trocar('moeda.ValorReal.Variacao',		$pI->valorReal->moeda());
	$iTDT->enterRepeticao($repeticaoVariacoes)->trocar('valor.ValorVenda.Variacao',		$pI->valorVenda->num ? $pI->valorVenda->formatar() : 0);
	$iTDT->enterRepeticao($repeticaoVariacoes)->trocar('moeda.ValorVenda.Variacao',	$pI->valorVenda->moeda());
	
	$iTDT->enterRepeticao($repeticaoVariacoes)->trocar('estoque.Variacao',				$pI->estoque);
	$iTDT->enterRepeticao($repeticaoVariacoes)->trocar('peso.Variacao',					$pI->peso->formatar());
	$iTDT->enterRepeticao($repeticaoVariacoes)->trocar('altura.Variacao',				$pI->altura->formatar());
	$iTDT->enterRepeticao($repeticaoVariacoes)->trocar('largura.Variacao',				$pI->largura->formatar());
	$iTDT->enterRepeticao($repeticaoVariacoes)->trocar('comprimento.Variacao',			$pI->comprimento->formatar());
	$iTDT->enterRepeticao($repeticaoVariacoes)->trocar('formato.Variacao',				1);
	$iTDT->enterRepeticao($repeticaoVariacoes)->trocar('tipoUnidade.Variacao',			$idioma->getTraducaoByConteudo($pI->tipoUnidade)->traducao);
	$iTDT->enterRepeticao($repeticaoVariacoes)->trocar('quantidade.Variacao',			$pI->quantidadeu > 0 ? 1 : '');
	$iTDT->enterRepeticao($repeticaoVariacoes)->trocar('descricaoP.Variacao',			$idioma->getTraducaoByConteudo($pI->descricaoPequena)->traducao);
	$iTDT->enterRepeticao($repeticaoVariacoes)->trocar('descricao.Variacao', 			$idioma->getTraducaoByConteudo($pI->descricao)->traducao);
	
	$iTDT->enterRepeticao($repeticaoVariacoes)->trocar('descricaoPSimples.Variacao',	strip_tags($idioma->getTraducaoByConteudo($pI->descricaoPequena)->traducao));
	$iTDT->enterRepeticao($repeticaoVariacoes)->trocar('descricaoSimples.Variacao', 	strip_tags($idioma->getTraducaoByConteudo($pI->descricao)->traducao));
	$iTDT->enterRepeticao($repeticaoVariacoes)->trocar('linkPedido.Variacao', 			Sistema::$caminhoURL.$_SESSION['lang']."/processar-carrinho&produto=".$pI->getId());
	
	$iTDT->enterRepeticao($repeticaoVariacoes)->condicao('condicao->Video.Variacao', $pI->getVideo());
	if($pI->getVideo()!= '')
		$iTDT->enterRepeticao($repeticaoVariacoes)->trocar('video', 			$pI->getVideo());
	
	$idOpcoes = '';
	$iTDT->enterRepeticao($repeticaoVariacoes)->createRepeticao('repetir->ProdutoOpcoes.Variacao');
	while($pOG = $pI->getOpcoes()->listar('ASC', ListaProdutoOpcaoGerados::OPCAO)){
		
		if($pOG->getOpcao()->aberto && $pOG->getOpcao()->multi){
		
			$idOpcoes .= $pOG->getValor()->getId();
			
			$existe = false;
			foreach($arrayOpcoes[$pOG->getOpcao()->getId()] as $pOV){
				if($pOV['id'] == $pOG->getValor()->getId())
					$existe = true;
			}
			
			if(!$existe)
				$arrayOpcoes[$pOG->getOpcao()->getId()][] = array('id' => $pOG->getValor()->getId(), 'valor' => $pOG->getValor()->valor, 'cor' => $pOG->getValor()->cor, 'image' => ($pOG->getValor()->getImage()->nome != '') ? $pOG->getValor()->getImage()->nome.".".$pOG->getValor()->getImage()->extensao : '');
			
			$iTDT->enterRepeticao($repeticaoVariacoes)->repetir();
			$iTDT->enterRepeticao($repeticaoVariacoes)->enterRepeticao()->trocar('id.ProdutoOpcao', $pOG->getOpcao()->getId());
			$iTDT->enterRepeticao($repeticaoVariacoes)->enterRepeticao()->trocar('id.ProdutoOpcaoValor.ProdutoOpcao', $pOG->getValor()->getId());
			$iTDT->enterRepeticao($repeticaoVariacoes)->enterRepeticao()->trocar('valor.ProdutoOpcaoValor.ProdutoOpcao', addslashes($pOG->getValor()->valor));
			$iTDT->enterRepeticao($repeticaoVariacoes)->enterRepeticao()->trocar('cor.ProdutoOpcaoValor.ProdutoOpcao', $pOG->getValor()->cor);
			
		}
		
	}
	
	foreach($iTDT->enterRepeticao()->getRepeticoes('repetir->ProdutoOpcoes.Variacao') as $k => $t)
		if(is_int($k))
			$t->trocar('id.Opcoes.Variacao', $idOpcoes);
	$iTDT->enterRepeticao()->trocar('id.Opcoes.Variacao', $idOpcoes);
	
	
	$parcelas = Pedido::__ParcelasPagSeguro($pI->valor->num);
	$iTDT->enterRepeticao($repeticaoVariacoes)->createRepeticao("repetir->PagSeguro.Variacao");
	foreach($parcelas as $k => $v){
		$iTDT->enterRepeticao($repeticaoVariacoes)->repetir();
		$iTDT->enterRepeticao($repeticaoVariacoes)->enterRepeticao()->trocar('parcela.PagSeguro.Variacao', $k);
		$iTDT->enterRepeticao($repeticaoVariacoes)->enterRepeticao()->trocar('valor.parcela.PagSeguro.Variacao', Numero::__CreateNumero($v)->moeda());
		$iTDT->enterRepeticao($repeticaoVariacoes)->condicao('condicao->Parcela'.$k.'.pagSeguro.valor.Produto',  $v > PagamentoPagSeguro::PARCELAMINIMA && $rsP['ativopagseguro']);
		$iTDT->enterRepeticao($repeticaoVariacoes)->trocar('parcela'.$k.'.pagSeguro.valor.Variacao',  Numero::__CreateNumero($v)->moeda());
	}
	
	
	$iTDT->enterRepeticao($repeticaoVariacoes)->createRepeticao("repetir->Imagens.Variacao");
	$iTDT->enterRepeticao($repeticaoVariacoes)->condicao("condicao->Imagens.Variacao", $pI->getImagens()->getTotal() > 0);
	
	if($pI->getImagens()->getTotal() > 0){
	
		$img = $pI->getImagens()->listar("DESC", ListaImagens::DESTAQUE);
		$iTDT->enterRepeticao($repeticaoVariacoes)->trocar('imagem.Variacao', $img->getImage()->showHTML(308, 272));
		$iTDT->enterRepeticao($repeticaoVariacoes)->trocar('url.Imagem.Variacao', Sistema::$caminhoURL.Sistema::$caminhoDataProdutos.$img->getImage()->nome.'.'.$img->getImage()->extensao);
	
		$pI->getImagens()->setParametros(0);
		while($img = $pI->getImagens()->listar("DESC", ListaImagens::DESTAQUE)){
	
			$iTDT->enterRepeticao($repeticaoVariacoes)->repetir();
			$iTDT->enterRepeticao($repeticaoVariacoes)->enterRepeticao()->trocar('posicao.Imagem.Variacao', $pI->getImagens()->getParametros());
			$iTDT->enterRepeticao($repeticaoVariacoes)->enterRepeticao()->trocar('url.Imagem.Variacao', Sistema::$caminhoURL.Sistema::$caminhoDataProdutos.$img->getImage()->nome.'.'.$img->getImage()->extensao);
			$iTDT->enterRepeticao($repeticaoVariacoes)->enterRepeticao()->trocar('url.medium.Imagem.Variacao', $img->getImage()->pathImage(308, 272));
			$iTDT->enterRepeticao($repeticaoVariacoes)->enterRepeticao()->trocar('url.thumb.Imagem.Variacao', $img->getImage()->pathImage(54, 54));
	
		}
	
	}
	
	//
	
}

//

$lPO = new ListaProdutoOpcoes;

$nomeOpcoes = explode(",", $p->tipoUnidade);
$iTDT->createRepeticao("repetir->Opcoes.Interface");
$iTDT->createRepeticao('repetir->ProdutoOpcoes.ChecarInfo');
$iTDT->createRepeticao('repetir->ProdutoOpcoes.ChecarInicioInfo');
$iTDT->createRepeticao('repetir->ProdutoOpcoes.CarregarInfo');
for($op = 1; $op <= ($p->quantidadeu > 0 ? $p->quantidadeu : 1); $op++){

	$iTDT->repetir("repetir->Opcoes.Interface");
	
	$iTDT->enterRepeticao("repetir->Opcoes.Interface")->trocar('nome.Opcao', trim($nomeOpcoes[$op-1]));
	$iTDT->enterRepeticao("repetir->Opcoes.Interface")->trocar('numero.Opcao', $op);
	
	$iTDT->enterRepeticao("repetir->Opcoes.Interface")->createRepeticao("repetir->ProdutoOpcoes.Opcao");
	
	foreach($arrayOpcoes as $k => $v){
		
		$lPO->condicoes('', $k, ListaProdutoOpcoes::ID);
		
		if($lPO->getTotal() > 0){
			
			$pO = $lPO->listar();
			
			$array = $v;
			//$array = $array->ordenarMatriz('valor', 'ASC');
			
			if($op == 1){
				
				$iTDT->repetir('repetir->ProdutoOpcoes.ChecarInfo');
				$iTDT->enterRepeticao('repetir->ProdutoOpcoes.ChecarInfo')->trocar("id.ProdutoOpcao", $pO->getId());
				
				$iTDT->repetir('repetir->ProdutoOpcoes.ChecarInicioInfo');
				$iTDT->enterRepeticao('repetir->ProdutoOpcoes.ChecarInicioInfo')->trocar("id.ProdutoOpcao", $pO->getId());
				
				$iTDT->repetir('repetir->ProdutoOpcoes.CarregarInfo');
				$iTDT->enterRepeticao('repetir->ProdutoOpcoes.CarregarInfo')->trocar("id.ProdutoOpcao", $pO->getId());
			}
			
			$iTDT->enterRepeticao("repetir->Opcoes.Interface")->repetir();
			$iTDT->enterRepeticao("repetir->Opcoes.Interface")->enterRepeticao()->condicao("condicao->Aberto.ProdutoOpcao", $pO->aberto);
			$iTDT->enterRepeticao("repetir->Opcoes.Interface")->enterRepeticao()->trocar("id.ProdutoOpcao", $pO->getId());
			$iTDT->enterRepeticao("repetir->Opcoes.Interface")->enterRepeticao()->trocar("nome.ProdutoOpcao", $idioma->getTraducaoById(ListaProdutoOpcoes::NOME, $lPO->getTabela(), $pO->getId())->traducao);
			$iTDT->enterRepeticao("repetir->Opcoes.Interface")->enterRepeticao()->trocar("cor.ProdutoOpcao", $pO->cor);
			
			$iTDT->enterRepeticao("repetir->Opcoes.Interface")->enterRepeticao()->createRepeticao('repetir->ProdutoOpcaoValores.ProdutoOpcao');
			foreach($array as $pOV){
				
				$iTDT->enterRepeticao("repetir->Opcoes.Interface")->enterRepeticao()->repetir();
				$iTDT->enterRepeticao("repetir->Opcoes.Interface")->enterRepeticao()->enterRepeticao()->trocar('id.ProdutoOpcaoValor.ProdutoOpcao', $pOV['id']);
				$iTDT->enterRepeticao("repetir->Opcoes.Interface")->enterRepeticao()->enterRepeticao()->trocar('valor.ProdutoOpcaoValor.ProdutoOpcao', $pOV['valor']);
				$iTDT->enterRepeticao("repetir->Opcoes.Interface")->enterRepeticao()->enterRepeticao()->trocar('cor.ProdutoOpcaoValor.ProdutoOpcao', $pOV['cor']);
				
			}
		}
		
	}

}

$lR = new ListaRecados;
$aRR[1] = array('campo' => ListaRecados::SESSAO, 'valor' => 'produtos');
$aRR[2] = array('campo' => ListaRecados::IDSESSAO, 'valor' => $p->getId());
$aRR[3] = array('campo' => ListaRecados::LIBERADO, 'valor' => ListaRecados::VALOR_LIBERADO_TRUE);
$lR->condicoes($aRR);
$iTDT->createRepeticao('repetir->Recados');
while($r = $lR->listar("DESC", ListaRecados::DATA)){
	
	$iTDT->repetir();
	$iTDT->enterRepeticao()->trocar("nome.Recado", $r->nome);
	$iTDT->enterRepeticao()->trocar("local.Recado", $r->local);
	$iTDT->enterRepeticao()->trocar("titulo.Recado", $r->getTexto()->titulo);
	$iTDT->enterRepeticao()->trocar("texto.Recado", $r->getTexto()->texto);
	
}

$javaScript .= $iTDT->createJavaScript()->concluir();
$javaScript .= $arrayScript;

$includePagina = $iTDT->concluir();

?>