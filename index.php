<?php

include('./lib.conf/includes.php');

importar("Geral.InterFaces");
importar("Geral.Idiomas.Lista.ListaIdiomas");
importar("Geral.Lista.ListaURLs");
importar("LojaVirtual.Pedidos.Lista.ListaPedidos");
importar("TemTudoAqui.Usuarios.Lista.ListaPessoas");
importar("LojaVirtual.Produtos.Lista.ListaProdutoMarcas");
importar("LojaVirtual.Categorias.Lista.ListaProdutoCategorias");
importar("Utilidades.Publicidades.Slides.Lista.ListaSlideCategorias");
importar("Utilidades.Publicidades.Banners.Lista.ListaBannerCategorias");
importar("Utilidades.Galerias.Lista.ListaGaleriaCategorias");
importar("Utilidades.Publicidades.Mailing.Lista.ListaPacoteMailings");
importar("Utils.Dados.JSON");

$pagina			= empty($_GET['p']) ? '' : $_GET['p'];
$procura		= empty($_GET['procura']) ? '' : $_GET['procura'];
$procura2		= empty($_GET['procura2']) ? '' : $_GET['procura2'];
$_GET['pag']	= empty($_GET['pag']) ? '' : $_GET['pag'];
$titulo			= '';
$imagem			= '';
$descricao		= '';

if(!empty($_SESSION['lang'])){

    if(!empty($_GET['lang'])){

        if($_GET['lang'] == 'favicon.ico'){
            $_GET['lang'] = 'br';
            $_SESSION['lang'] = 'br';
            header("Location: ".Sistema::$caminhoURL.'br');
            exit;
        }elseif($_GET['lang'] == 'lib.templates'){
            $_GET['lang'] = 'br';
            $_SESSION['lang'] = 'br';
            header("Location: ".Sistema::$caminhoURL.'br');
            exit;
        }elseif($_GET['lang'] == '500.shtml'){
            $_GET['lang'] = 'br';
            $_SESSION['lang'] = 'br';
            header("Location: ".Sistema::$caminhoURL.'br');
            exit;
        }

        $_SESSION['lang'] = $_GET['lang'];
    }else{
        header("Location: ".Sistema::$caminhoURL.$_SESSION['lang']);
        exit;
    }

}elseif(!empty($_GET['lang'])){

    if($_GET['lang'] == 'favicon.ico'){
        $_GET['lang'] = 'br';
        $_SESSION['lang'] = 'br';
        header("Location: ".Sistema::$caminhoURL.'br');
        exit;
    }elseif($_GET['lang'] == 'lib.templates'){
        $_GET['lang'] = 'br';
        $_SESSION['lang'] = 'br';
        header("Location: ".Sistema::$caminhoURL.'br');
        exit;
    }elseif($_GET['lang'] == '500.shtml'){
        $_GET['lang'] = 'br';
        $_SESSION['lang'] = 'br';
        header("Location: ".Sistema::$caminhoURL.'br');
        exit;
    }

    $_SESSION['lang'] = $_GET['lang'];

}elseif(empty($_GET['lang'])){

    header("Location: ".Sistema::$caminhoURL."br");
    exit;
}


if(empty($pagina))
    $iT 		= new InterFaces(new Arquivos(Sistema::$layoutCaminhoDiretorio."index.html"));
else
    $iT 		= new InterFaces(new Arquivos(Sistema::$layoutCaminhoDiretorio."index-interna.html"));

$iT->setSESSION($_SESSION);
$iT->trocar('lang', $_SESSION['lang']);
$iT->trocar("moeda", "U$");

$iT->condicao("condicao->Usuario", !empty($_SESSION['usuario']));

//URL`s
$url = Sistema::$caminhoURL.$_SESSION['lang'].(!empty($pagina) ? "/".$pagina.(!empty($procura) ? "/".$procura.(!empty($procura2) ? "/".$procura2 : '') : '') : '').(!empty($_GET['pag']) ? "&pag=".$_GET['pag'] : '');
//

//Filtros
$arrayFiltros = array();
foreach($_GET as $k => $v){
	if(preg_match("!filtro!", $k)){
		$arrayFiltros[str_replace('filtro', '', $k)] = $v;
	}
}
//

//Idiomas
$lI  		= new ListaIdiomas;
$iT->trocar('linkVisualizar.BR.Idioma', Sistema::$caminhoURL."br"."/".$pagina.(!empty($procura) ? "/".$procura : '').(!empty($procura2) ? "/".$procura2 : '').(!empty($_GET['pedido']) ? "&pedido=".$_GET['pedido'] : ''));
$iT->createRepeticao("repetir->Idiomas");
while($i = $lI->listar()){
	
	$iT->repetir();
	
	if($i->getImagem()->nome != "")
		$iT->enterRepeticao()->trocar('imagem.Idioma', $i->getImagem()->showHTML(50, 20));
	
	$iT->enterRepeticao()->trocar('nome.Idioma', $i->nome);
	$iT->enterRepeticao()->trocar('linkVisualizar.Idioma', Sistema::$caminhoURL.$i->sigla."/".$pagina.(!empty($procura) ? "/".$procura : '').(!empty($procura2) ? "/".$procura2 : '').(!empty($_GET['pedido']) ? "&pedido=".$_GET['pedido'] : ''));
	
}

if($lI->condicoes('', $_SESSION['lang'], ListaIdiomas::SIGLA)->getTotal() > 0)
	$idioma = $lI->listar();
else{
	$idioma = new Idioma;
	$idioma->sigla = 'br';
}

$lI->close();
//


if(empty($_SESSION['usuario'])){
	$iT->trocar('mensagem.Sacola', $idioma->getTraducaoByConteudo('Não há nenhum item')->traducao);
	$iT->trocar('numero.Sacola', "0");
}else{
	
	$lP = new ListaPessoas;
	$lP->condicoes('', $_SESSION['usuario']['id'], ListaPessoas::ID);
	
	if($lP->getTotal() > 0){
		
		$p = $lP->listar();
		$lPE = new ListaPedidos;
		$condP[1] = array('campo' => ListaPedidos::IDSESSAO, 'valor' => $p->getId());
		$condP[2] = array('campo' => ListaPedidos::STATUS, 'valor' => PedidoStatus::ABERTO);
		$lPE->condicoes($condP);
		if($lPE->getTotal() > 0){
			$ped = $lPE->listar();
			if($ped->getItem()->getTotal() == 0){
				$iT->trocar('mensagem.Sacola', $idioma->getTraducaoByConteudo('Não há nenhum item')->traducao);
				$iT->trocar('numero.Sacola', "0");
			}else{
				$iT->trocar('mensagem.Sacola', $idioma->getTraducaoByConteudo('Há')->traducao.' '.$ped->getItem()->getTotal().' item(s)');
				$iT->trocar('numero.Sacola', $ped->getItem()->getTotal());
			}
		}else{
			$iT->trocar('mensagem.Sacola', $idioma->getTraducaoByConteudo('Não há nenhum item')->traducao);
			$iT->trocar('numero.Sacola', "0");
		}

        $lPE->close();
		
	}else{
		$iT->trocar('mensagem.Sacola', $idioma->getTraducaoByConteudo('Não há nenhum item')->traducao);
		$iT->trocar('numero.Sacola', "0");
	}

    $lP->close();

}

if(!empty($_POST['email-news'])){
	
	$lPM = new ListaPacoteMailings;
	$lPM->condicoes('', 1, ListaPacoteMailings::ID);
	if($lPM->getTotal() > 0){
		
		$pM = $lPM->listar();
		try{
			$pM->addEmail($_POST['email-news'], $_POST['nome-news']);
			$cond['msg'] = $idioma->getTraducaoByConteudo("E-mail cadastrado com sucesso")->traducao."!";
		}catch(Exception $e){
			$cond['msg'] = $idioma->getTraducaoByConteudo($e->getMessage())->traducao."!";	
		}
	}

    $lPM->close();

	echo JSON::_Encode($cond);
	exit;
	
}

/*$lT = new ListaTextos;
$lT->condicoes('', 11, ListaTextos::ID);
if($lT->getTotal() > 0){
	$t = $lT->listar();
	$iT->trocar('titulo.CotacaoDolar', $idioma->getTraducaoByConteudo($t->titulo)->traducao);
	$iT->trocar('textoPequeno.CotacaoDolar', strip_tags($idioma->getTraducaoByConteudo($t->textoPequeno)->traducao));
}*/

$lSC = new ListaSlideCategorias;
$lSC->condicoes('', 1, ListaSlideCategorias::ID);
if($lSC->getTotal() > 0){
		
	$sC = $lSC->listar();
	
	$total = 0;
	$iT->createRepeticao("repetir->Slides");
	while($s = $sC->getSlides()->listar('ASC', ListaSlides::ORDEM)){
		
		if($s->ativo){
			$iT->repetir();
			$total++;
			$iT->enterRepeticao()->trocar('url.Imagem.Slide', $s->getImagem()->pathImage(2500, 517));
			$iT->enterRepeticao()->trocar('imagem.Slide', $s->getImagem()->showHTML(2000, 517));
			$iT->enterRepeticao()->trocar('enderecoURL.Slide', $s->enderecoURL);
			$iT->enterRepeticao()->trocar('legenda.Slide', $s->legenda);
			$iT->enterRepeticao()->trocar('posicao.Slides', $total);

		}
	
	}
	
	$iT->condicao('condicao->Slides', $total > 0);
	
}else
	$iT->condicao('condicao->Slides', false);
	
$lSC->close();

/*$lBC = new ListaBannerCategorias;
$lBC->condicoes('', 1, ListaBannerCategorias::ID);
if($lBC->getTotal() > 0){
		
	$bC = $lBC->listar();
	
	$total = 0;
	$iT->createRepeticao("repetir->Banners");
	while($b = $bC->getBanners()->listar('ASC', ListaBanners::DATAINICIO)){
		
		if($b->ativo){
			$iT->repetir();
			$total++;
			$iT->enterRepeticao()->trocar('url.Imagem.Banner', $b->getImagem()->pathImage(3000, 3000));
			$iT->enterRepeticao()->trocar('imagem.Banner', $b->getImagem()->showHTML(3000, 3000));
			$iT->enterRepeticao()->trocar('enderecoURL.Banner', $b->enderecoURL);
			$iT->enterRepeticao()->trocar('legenda.Banner', $b->legenda);
			$iT->enterRepeticao()->trocar('posicao.Banners', $total);

		}
	
	}
	
	$iT->condicao('condicao->Banners', $total > 0);
	
}else
	$iT->condicao('condicao->Banners', false);*/

/*$lPM = new ListaProdutoMarcas;
$iT->createRepeticao("repetir->ProdutoMarcas");
while($pM = $lPM->listar("DESC", "rand()")){
	
	$iT->repetir();
	$iT->enterRepeticao()->trocar("imagem.ProdutoMarca", $pM->getImagem()->showHTML(150, 37));
	$iT->enterRepeticao()->trocar("url.Imagem.ProdutoMarca", $pM->getImagem()->pathImage(150, 37));
	$iT->enterRepeticao()->trocar("nome.ProdutoMarca", $pM->nome);
	$iT->enterRepeticao()->trocar("enderecoURL.ProdutoMarca", $pM->enderecoURL);
	$iT->enterRepeticao()->trocar("url.ProdutoMarca", $pM->getUrl()->url);
	$iT->enterRepeticao()->trocar("linkVisualizar.ProdutoMarca", Sistema::$caminhoURL.$_SESSION['lang']."/produtos&marca=".$pM->getURL()->url);

}*/


include('lateral-esquerda.php');
$iT->trocar('lateralEsquerda', $lateralEsquerda);


if(!empty($pagina)){
		
	$lU = new ListaURLs;
	
	$cond[1] = array('campo' => ListaURLs::URL, 	'valor' => $pagina);
	
	if($lU->condicoes($cond)->getTotal() > 0){
		
		$u = $lU->listar();
		
	}else
		$u = new URL;
	
}else
	$u = new URL;
	

unset($aR);
$aR[1] = array('campo' => ListaProdutos::DISPONIVEL, 'valor' => ListaProdutos::VALOR_DISPONIVEL_TRUE);
$aR[2] = array('campo' => ListaProdutos::LANCAMENTO, 'valor' => ListaProdutos::VALOR_DISPONIVEL_TRUE);
$aR[3] = array('campo' => ListaProdutos::REMOVIDO, 'valor' => ListaProdutos::VALOR_DISPONIVEL_FALSE);
$aR[4] = array('campo' => ListaProdutos::PRODUTOPAI, 'valor' => '');

/*
$lP = new ListaProdutos;
$lP->condicoes($aR);

$iT->condicao('condicao->Produtos', $lP->getTotal() > 0);
$iT->createRepeticao('repetir->Paginador.Produto');
$iT->createRepeticao('repetir->Produtos');

if($lP->getTotal() > 0){
	
	$con = BDConexao::__Abrir();
	$con->executar("SELECT * FROM ".Sistema::$BDPrefixo."pagamentos");
	$rsP = $con->getRegistro();
	
	$num = 0;
	$por = 6;
	$minimo = $_GET['pag']*$por;
	$maximo = $minimo+$por;
	
	$lP->setParametros($maximo, 'limite')->setParametros($minimo);
	
	while($p = $lP->listar()){
		
		$num++;
			
		$iT->repetir();
		
		$cat = $p->getCategorias()->listar();
		
		$iT->enterRepeticao()->trocar('id.Produto', $p->getId());
		$iT->enterRepeticao()->trocar('codigo.Produto', $p->codigo);
		$iT->enterRepeticao()->trocar('nome.Produto', $idioma->getTraducaoById(ListaProdutos::NOME, $lP->getTabela(), $p->getId())->traducao);
		$iT->enterRepeticao()->trocar('descricao.Produto',  $idioma->getTraducaoByConteudo($p->descricao)->traducao);
		
		$iT->enterRepeticao()->trocar('id.Marca.Produto', $p->getMarca()->getId());
		$iT->enterRepeticao()->trocar('nome.Marca.Produto', $idioma->getTraducaoById(ListaProdutoMarcas::NOME, "produtos_marcas", $p->getMarca()->getId())->traducao);
		$iT->enterRepeticao()->trocar('linkVisualizar.Marca.Produto', Sistema::$caminhoURL.$_SESSION['lang']."/produtos/".$p->getMarca()->getURL()->url);
		
		
		while($pI = $p->getInfos()->listar()){
			$p->estoque += $pI->estoque;
		}
		
		$linkVisualizar = Sistema::$caminhoURL.$_SESSION['lang'].'/produtos/'.(!empty($procura) ? $procura : ($cat ? $cat->getURL()->url : ''))."/".$p->getURL()->url;
		//echo $p->nome." - ".$p->estoque."<br>";
		if($p->estoque <= 0 && $p->tipoPedido != Produto::TIPO_PEDIDO_SOB_CONSULTA && $rsP['tipopedidoprodutostodosite'] != Produto::TIPO_PEDIDO_SOB_CONSULTA && $rsP['tiposite'] == 2 && $rsP['tipopedido'] != 1){
			$iT->enterRepeticao()->condicao('condicao->valor.Produto', false);
			$linkVisualizar .= '&pedido-estoque';
			$iT->enterRepeticao()->trocar('acao.Produto', $idioma->getTraducaoByConteudo('Encomendar')->traducao);
		}elseif($p->valorReal->num <= 0 || $p->tipoPedido == Produto::TIPO_PEDIDO_SOB_CONSULTA || $rsP['tipopedidoprodutostodosite'] == Produto::TIPO_PEDIDO_SOB_CONSULTA){
			$iT->enterRepeticao()->condicao('condicao->valor.Produto', false);
			$linkVisualizar .= '&consultar';
			$iT->enterRepeticao()->trocar('acao.Produto', $idioma->getTraducaoByConteudo('Sob Consulta')->traducao);
		}else
			$iT->enterRepeticao()->condicao('condicao->valor.Produto', true);
		
		$iT->enterRepeticao()->condicao('condicao->promocao.Produto',  $p->valorVenda->num < $p->valorReal->num && $p->valorVenda->num > 0);
		$iT->enterRepeticao()->trocar('valor.Produto',  "U$ ".$p->valorReal->moeda());
		$iT->enterRepeticao()->trocar('valorPromocional.Produto',  "U$ ".$p->valorVenda->moeda());
		$iT->enterRepeticao()->trocar('linkPedido.Produto',  Sistema::$caminhoURL.$_SESSION['lang']."/processar-carrinho&produto=".$p->getId());
		
		$parcelas = Pedido::__ParcelasPagSeguro($p->valor->num);
		foreach($parcelas as $k => $v){
			$iT->enterRepeticao()->condicao('condicao->Parcela'.$k.'.pagSeguro.valor.Produto',  $v > PagamentoPagSeguro::PARCELAMINIMA && $rsP['ativopagseguro']);
			$iT->enterRepeticao()->trocar('parcela'.$k.'.pagSeguro.valor.Produto',  Numero::__CreateNumero($v)->moeda());
		}
		if($p->getImagens()->getTotal() > 0){
			$img = $p->getImagens()->listar("DESC", ListaImagens::DESTAQUE);
			if($img->getImage()->nome != ''){
				$iT->enterRepeticao()->trocar('imagem.Produto', $img->getImage()->showHTML(119, 100));
				$iT->enterRepeticao()->trocar('url.Imagem.Produto', $img->getImage()->pathImage(119, 100));
			}
		}
		
		$iT->enterRepeticao()->trocar('linkVisualizar.Produto', $linkVisualizar);
		$iT->enterRepeticao()->trocar('linkAdicionar.Produto', Sistema::$caminhoURL.$_SESSION['lang']."/processar-carrinho&produto=".$p->getId());
		
	}
	
}*/



$total = 0;

//var_dump($u); exit;
if(file_exists($pagina.'.php'))
	include($pagina.'.php');
elseif(file_exists($u->tabela.'.php'))
	include($u->tabela.'.php');
else
	include('main.php');

$iT->trocar('includePagina', $includePagina);

//include('lateral-direita.php');
//$iT->trocar('lateralDireita', $lateralDireita);

$iT->trocar('titulo', ($titulo ? $titulo.' | ' : '').Sistema::$nomeEmpresa);
$iT->trocar('imagem', $imagem);
$iT->trocar('url', $url);
$iT->trocar('descricao', strip_tags(str_replace("\"", "", str_replace("\n", "", $descricao))));

$final = $iT->concluir();

/*if(!isset($_GET['newsletter']) && !isset($_GET['indicar']) && $pagina != 'contato' && $pagina != 'favoritos' && $pagina != 'carrinho' && $pagina != 'finalizar-pedido' && $pagina != 'historico-pedido' && $pagina != 'dados-cadastrais' && $pagina != 'enviar-pedido' && $pagina != 'pedido' && $pagina != 'cadastro' && $pagina != 'esqueceu-sua-senha' && $pagina != 'login' && $_SESSION['lang'] == 'br'){

	$pasta = "lib.data/cache/";
	
	@mkdir($pasta, 0777);
	@mkdir($pasta.$_SESSION['lang'], 0777);
	
	$pasta .= $_SESSION['lang']."/";
	
	if(!empty($pagina)){
		@mkdir($pasta.$pagina, 0777);
		$pasta .= $pagina."/";
	}
	if(!empty($procura)){
		@mkdir($pasta.$procura, 0777);
		$pasta .= $procura."/";
	}
	if(!empty($procura2)){
		@mkdir($pasta.$procura2, 0777);
		$pasta .= $procura2."/";
	}
	if(!empty($_SERVER['QUERY_STRING'])){
		@mkdir("lib.data/cache".$_SERVER['REQUEST_URI'], 0777);
		$pasta = "lib.data/cache".$_SERVER['REQUEST_URI']."/";
	}

	$f = @fopen($pasta."index.html", 'w+');
	@fwrite($f, $final);
	@fclose($f);

}*/

echo $final;

//mysql_close(BDConexao::$staticConnection);