<?php

importar("Utilidades.Publicidades.Banners.Lista.ListaBannerCategorias");
importar("LojaVirtual.Pedidos.Pagamentos.PagamentoPagSeguro");
importar("LojaVirtual.Categorias.Lista.ListaProdutoCategorias");
importar("LojaVirtual.Produtos.ProdutoBusca");

$iTM = new InterFaces(new Arquivos(Sistema::$layoutCaminhoDiretorio."main.html"));

$iTM->setSESSION($_SESSION);
$iTM->trocar('lang', $_SESSION['lang']);

//include('lateral-esquerda.php');
//$iTM->trocar('lateralEsquerda', $lateralEsquerda);

//Receptores
$lP = new ListaProdutos;
$lP->condicoes("", "", "", "", "SELECT p.* FROM ".Sistema::$BDPrefixo."relacionamento_produtos_categorias rpc INNER JOIN ".Sistema::$BDPrefixo."produtos p ON p.id = rpc.produto WHERE rpc.categoria = '144' AND (SELECT COUNT(i.id) FROM ".Sistema::$BDPrefixo."imagens i WHERE i.sessao = 'produtos' AND i.idsessao = p.id) > 0 AND p.disponivel = 1");

$iTM->condicao('condicao->Produtos.Receptores', $lP->getTotal() > 0);
$iTM->createRepeticao('repetir->Produtos.Receptores');

if($lP->getTotal() > 0){

    $con = BDConexao::__Abrir();
    $con->executar("SELECT * FROM ".Sistema::$BDPrefixo."pagamentos");
    $rsP = $con->getRegistro();
    $con->close();

    $num = 0;
    $por = 16;
    $minimo = $_GET['pag']*$por;
    $maximo = $minimo+$por;

    $lP->setParametros($maximo, 'limite')->setParametros($minimo);

    while($p = $lP->listar("DESC", "rand()")){

        $num++;

        $iTM->repetir();

        $cat = $p->getCategorias()->listar();

        $iTM->enterRepeticao()->trocar('id.Produto', $p->getId());
        $iTM->enterRepeticao()->trocar('codigo.Produto', $p->codigo);
        $iTM->enterRepeticao()->trocar('nome.Produto', $idioma->getTraducaoById(ListaProdutos::NOME, $lP->getTabela(), $p->getId())->traducao);
        $iTM->enterRepeticao()->trocar('descricaoPequena.Produto',  $idioma->getTraducaoByConteudo($p->descricaoPequena)->traducao);

        $iTM->enterRepeticao()->trocar('id.Marca.Produto', $p->getMarca()->getId());
        $iTM->enterRepeticao()->trocar('nome.Marca.Produto', $idioma->getTraducaoById(ListaProdutoMarcas::NOME, "produtos_marcas", $p->getMarca()->getId())->traducao);
        if($p->getMarca()->getImagem()->nome != '')
            $iTM->enterRepeticao()->trocar('imagem.Marca.Produto', $p->getMarca()->getImagem()->showHTML(200, 15));
        $iTM->enterRepeticao()->trocar('linkVisualizar.Marca.Produto', Sistema::$caminhoURL.$_SESSION['lang']."/produtos/&marca=".$p->getMarca()->getURL()->url);


        while($pI = $p->getInfos()->listar()){
            $p->estoque += $pI->estoque;
        }

        $linkVisualizar = Sistema::$caminhoURL.$_SESSION['lang'].'/produtos/'.(!empty($procura) ? $procura : ($cat ? $cat->getURL()->url : ''))."/".$p->getURL()->url;
        //echo $p->nome." - ".$p->estoque."<br>";
        if($p->estoque <= 0 && $p->tipoPedido != Produto::TIPO_PEDIDO_SOB_CONSULTA && $rsP['tipopedidoprodutostodosite'] != Produto::TIPO_PEDIDO_SOB_CONSULTA && $rsP['tiposite'] == 2 && $rsP['tipopedido'] != 1){
            $iTM->enterRepeticao()->condicao('condicao->valor.Produto', false);
            $linkVisualizar .= '&pedido-estoque';
            $iTM->enterRepeticao()->trocar('acao.Produto', $idioma->getTraducaoByConteudo('Encomendar')->traducao);
        }elseif($p->valorReal->num <= 0 || $p->tipoPedido == Produto::TIPO_PEDIDO_SOB_CONSULTA || $rsP['tipopedidoprodutostodosite'] == Produto::TIPO_PEDIDO_SOB_CONSULTA){
            $iTM->enterRepeticao()->condicao('condicao->valor.Produto', false);
            $linkVisualizar .= '&consultar';
            $iTM->enterRepeticao()->trocar('acao.Produto', $idioma->getTraducaoByConteudo('Sob Consulta')->traducao);
        }else
            $iTM->enterRepeticao()->condicao('condicao->valor.Produto', true);

        $iTM->enterRepeticao()->condicao('condicao->promocao.Produto',  $p->valorVenda->num < $p->valorReal->num && $p->valorVenda->num > 0);
        $iTM->enterRepeticao()->trocar('valor.Produto',  "$ ".$p->valorReal->formatar());
        $iTM->enterRepeticao()->trocar('valorPromocional.Produto',  "$ ".$p->valorVenda->formatar());
        $iTM->enterRepeticao()->trocar('linkPedido.Produto',  Sistema::$caminhoURL.$_SESSION['lang']."/processar-carrinho&produto=".$p->getId());

        $parcelas = Pedido::__ParcelasPagSeguro($p->valor->num);
        foreach($parcelas as $k => $v){
            $iTM->enterRepeticao()->condicao('condicao->Parcela'.$k.'.pagSeguro.valor.Produto',  $v > PagamentoPagSeguro::PARCELAMINIMA && $rsP['ativopagseguro']);
            $iTM->enterRepeticao()->trocar('parcela'.$k.'.pagSeguro.valor.Produto',  Numero::__CreateNumero($v)->formatar());
        }
        if($p->getImagens()->getTotal() > 0){
            $img = $p->getImagens()->listar("DESC", ListaImagens::DESTAQUE);
            if($img->getImage()->nome != ''){
                $iTM->enterRepeticao()->trocar('imagem.Produto', $img->getImage()->showHTML(270, 290));
                $iTM->enterRepeticao()->trocar('url.Imagem.Produto', $img->getImage()->pathImage(270, 290));
            }
        }

        $iTM->enterRepeticao()->trocar('linkVisualizar.Produto', $linkVisualizar);
        $iTM->enterRepeticao()->trocar('linkAdicionar.Produto', Sistema::$caminhoURL.$_SESSION['lang']."/processar-carrinho&produto=".$p->getId());

        $idp = $p->getProdutoPai() > 0 ? $p->getProdutoPai() : $p->getId();

        $sqlOpcoes = "SELECT pov.*,
							po.nome as nomeopcao,
							po.tipo,
							(SELECT u.url
								FROM ".Sistema::$BDPrefixo."urls u
								WHERE u.tabela = 'produtos'
									AND u.valor = pog.produto) as url
						FROM ".Sistema::$BDPrefixo."produtos_opcoes_gerados pog
						INNER JOIN ".Sistema::$BDPrefixo."produtos_opcoes po
							ON po.id = pog.opcao
						INNER JOIN ".Sistema::$BDPrefixo."produtos_opcoes_valores pov
							ON pov.id = pog.valor
						WHERE pog.produto IN (SELECT p.id
												FROM ".Sistema::$BDPrefixo."produtos p
												WHERE p.id = '".$idp."' OR p.produtopai = '".$idp."')
							AND po.multi = 1
							AND po.aberto = 1
						GROUP BY pov.id
						ORDER BY nomeopcao, pov.valor ASC";
        $con->executar($sqlOpcoes);
        $iTM->enterRepeticao()->createRepeticao("repetir->ProdutoOpcoes.Produto");
        $opcao = 0;
        while($rsPO = $con->getRegistro()){
            if($opcao != $rsPO['opcao']){
                $iTM->enterRepeticao()->repetir();
                $iTM->enterRepeticao()->enterRepeticao()->condicao("condicao->Texto.ProdutoOpcao.Produto", $rsPO['tipo'] == 0);
                $iTM->enterRepeticao()->enterRepeticao()->condicao("condicao->Cor.ProdutoOpcao.Produto", $rsPO['tipo'] == 2);
                $iTM->enterRepeticao()->enterRepeticao()->trocar("nome.ProdutoOpcao.Produto", $rsPO['nomeopcao']);
                $iTM->enterRepeticao()->enterRepeticao()->createRepeticao('repetir->ProdutoOpcaoValores.ProdutoOpcao.Produto');
                $opcao = $rsPO['opcao'];
            }
            $iTM->enterRepeticao()->enterRepeticao()->repetir();
            $iTM->enterRepeticao()->enterRepeticao()->enterRepeticao()->trocar("valor.ProdutoOpcaoValor.ProdutoOpcao.Produto", $rsPO['valor']);
            $iTM->enterRepeticao()->enterRepeticao()->enterRepeticao()->trocar("cor.ProdutoOpcaoValor.ProdutoOpcao.Produto", $rsPO['cor']);
            $iTM->enterRepeticao()->enterRepeticao()->enterRepeticao()->trocar("linkVisualizar.ProdutoOpcaoValor.ProdutoOpcao.Produto", Sistema::$caminhoURL.$_SESSION['lang'].'/produtos/'.(!empty($procura) ? $procura : ($cat ? $cat->getURL()->getURL() : ''))."/".(empty($rsPO['url']) ? $p->getURL()->url : $rsPO['url']));
        }

    }

}
//

$lBC = new ListaBannerCategorias;
$lBC->condicoes('', 1, ListaBannerCategorias::ID);
if($lBC->getTotal() > 0){
		
	$bC = $lBC->listar();
	
	$total = 0;
	$iTM->createRepeticao("repetir->Banners.Banner1");
	while($b = $bC->getBanners()->listar('ASC', ListaBanners::DATAINICIO)){
		
		if($b->ativo){
			$iTM->repetir();
			$total++;
			$iTM->enterRepeticao()->trocar('url.Imagem.Banner', $b->getImagem()->pathImage(1176, 188));
			$iTM->enterRepeticao()->trocar('imagem.Banner', $b->getImagem()->showHTML(1176, 188));
			$iTM->enterRepeticao()->trocar('enderecoURL.Banner', $b->enderecoURL);
			$iTM->enterRepeticao()->trocar('legenda.Banner', $b->legenda);
			$iTM->enterRepeticao()->trocar('posicao.Banners', $total);

		}
	
	}
	
	$iTM->condicao('condicao->Banners.Banner1', $total > 0);
	
}else
	$iTM->condicao('condicao->Banners.Banner1', false);
$lBC->close();

$lBC = new ListaBannerCategorias;
$lBC->condicoes('', 2, ListaBannerCategorias::ID);
if($lBC->getTotal() > 0){

	$bC = $lBC->listar();

	$total = 0;
	$iTM->createRepeticao("repetir->Banners.BannerMedio1");
	while($b = $bC->getBanners()->listar('ASC', ListaBanners::DATAINICIO)){

		if($b->ativo){
			$iTM->repetir();
			$total++;
			$iTM->enterRepeticao()->trocar('url.Imagem.Banner', $b->getImagem()->pathImage(1176, 188));
			$iTM->enterRepeticao()->trocar('imagem.Banner', $b->getImagem()->showHTML(1176, 188));
			$iTM->enterRepeticao()->trocar('enderecoURL.Banner', $b->enderecoURL);
			$iTM->enterRepeticao()->trocar('legenda.Banner', $b->legenda);
			$iTM->enterRepeticao()->trocar('posicao.Banners', $total);

		}

	}

	$iTM->condicao('condicao->Banners.BannerMedio1', $total > 0);

}else
	$iTM->condicao('condicao->Banners.BannerMedio1', false);
$lBC->close();

$lBC = new ListaBannerCategorias;
$lBC->condicoes('', 3, ListaBannerCategorias::ID);
if($lBC->getTotal() > 0){

	$bC = $lBC->listar();

	$total = 0;
	$iTM->createRepeticao("repetir->Banners.BannerMedio2");
	while($b = $bC->getBanners()->listar('ASC', ListaBanners::DATAINICIO)){

		if($b->ativo){
			$iTM->repetir();
			$total++;
			$iTM->enterRepeticao()->trocar('url.Imagem.Banner', $b->getImagem()->pathImage(1176, 188));
			$iTM->enterRepeticao()->trocar('imagem.Banner', $b->getImagem()->showHTML(1176, 188));
			$iTM->enterRepeticao()->trocar('enderecoURL.Banner', $b->enderecoURL);
			$iTM->enterRepeticao()->trocar('legenda.Banner', $b->legenda);
			$iTM->enterRepeticao()->trocar('posicao.Banners', $total);

		}

	}

	$iTM->condicao('condicao->Banners.BannerMedio2', $total > 0);

}else
	$iTM->condicao('condicao->Banners.BannerMedio2', false);
$lBC->close();

$lBC = new ListaBannerCategorias;
$lBC->condicoes('', 4, ListaBannerCategorias::ID);
if($lBC->getTotal() > 0){

	$bC = $lBC->listar();

	$total = 0;
	$iTM->createRepeticao("repetir->Banners.BannerRodape");
	while($b = $bC->getBanners()->listar('ASC', ListaBanners::DATAINICIO)){

		if($b->ativo){
			$iTM->repetir();
			$total++;
			$iTM->enterRepeticao()->trocar('url.Imagem.Banner', $b->getImagem()->pathImage(1176, 188));
			$iTM->enterRepeticao()->trocar('imagem.Banner', $b->getImagem()->showHTML(1176, 188));
			$iTM->enterRepeticao()->trocar('enderecoURL.Banner', $b->enderecoURL);
			$iTM->enterRepeticao()->trocar('legenda.Banner', $b->legenda);
			$iTM->enterRepeticao()->trocar('posicao.Banners', $total);

		}

	}

	$iTM->condicao('condicao->Banners.BannerRodape', $total > 0);

}else
	$iTM->condicao('condicao->Banners.BannerRodape', false);
$lBC->close();

unset($aR);
$aR[1] = array('campo' => ListaProdutos::DISPONIVEL, 'valor' => ListaProdutos::VALOR_DISPONIVEL_TRUE);
//$aR[2] = array('campo' => ListaProdutos::DESTAQUE, 'valor' => ListaProdutos::VALOR_DISPONIVEL_TRUE);
//$aR[3] = array('campo' => ListaProdutos::REMOVIDO, 'valor' => ListaProdutos::VALOR_DISPONIVEL_FALSE);
$aR[2] = array('campo' => ListaProdutos::PRODUTOPAI, 'valor' => '');

$lP = new ListaProdutos;
$lP->condicoes($aR);
/*$lP->condicoes("", "", "", "", "SELECT p.* FROM ".Sistema::$BDPrefixo."produtos p WHERE (SELECT COUNT(i.id) FROM ".Sistema::$BDPrefixo."imagens i WHERE i.sessao = 'produtos' AND i.idsessao = p.id) > 0 AND p.disponivel = 1");*/

$iTM->condicao('condicao->Produtos', $lP->getTotal() > 0);
$iTM->createRepeticao('repetir->Paginador.Produto');
$iTM->createRepeticao('repetir->Produtos');

if($lP->getTotal() > 0){

	$con = BDConexao::__Abrir();
	$con->executar("SELECT * FROM ".Sistema::$BDPrefixo."pagamentos");
	$rsP = $con->getRegistro();
    $con->close();

	$num = 0;
	$por = 8;
	$minimo = $_GET['pag']*$por;
	$maximo = $minimo+$por;

	$lP->setParametros($maximo, 'limite')->setParametros($minimo);

	while($p = $lP->listar("DESC")){

		$num++;

        if($p->getImagens()->getTotal() > 0) {

            $iTM->repetir();

            $cat = $p->getCategorias()->listar();

            $iTM->enterRepeticao()->trocar('id.Produto', $p->getId());
            $iTM->enterRepeticao()->trocar('codigo.Produto', $p->codigo);
            $iTM->enterRepeticao()->trocar('nome.Produto', $idioma->getTraducaoById(ListaProdutos::NOME, $lP->getTabela(), $p->getId())->traducao);
            $iTM->enterRepeticao()->trocar('descricaoPequena.Produto', $idioma->getTraducaoByConteudo($p->descricaoPequena)->traducao);

            $iTM->enterRepeticao()->trocar('id.Marca.Produto', $p->getMarca()->getId());
            $iTM->enterRepeticao()->trocar('nome.Marca.Produto', $idioma->getTraducaoById(ListaProdutoMarcas::NOME, "produtos_marcas", $p->getMarca()->getId())->traducao);
            if ($p->getMarca()->getImagem()->nome != '')
                $iTM->enterRepeticao()->trocar('imagem.Marca.Produto', $p->getMarca()->getImagem()->showHTML(200, 15));
            $iTM->enterRepeticao()->trocar('linkVisualizar.Marca.Produto', Sistema::$caminhoURL . $_SESSION['lang'] . "/produtos/&marca=" . $p->getMarca()->getURL()->url);


            while ($pI = $p->getInfos()->listar()) {
                $p->estoque += $pI->estoque;
            }

            $linkVisualizar = Sistema::$caminhoURL . $_SESSION['lang'] . '/produtos/' . (!empty($procura) ? $procura : ($cat ? $cat->getURL()->url : '')) . "/" . $p->getURL()->url;
            //echo $p->nome." - ".$p->estoque."<br>";
            if ($p->estoque <= 0 && $p->tipoPedido != Produto::TIPO_PEDIDO_SOB_CONSULTA && $rsP['tipopedidoprodutostodosite'] != Produto::TIPO_PEDIDO_SOB_CONSULTA && $rsP['tiposite'] == 2 && $rsP['tipopedido'] != 1) {
                $iTM->enterRepeticao()->condicao('condicao->valor.Produto', false);
                $linkVisualizar .= '&pedido-estoque';
                $iTM->enterRepeticao()->trocar('acao.Produto', $idioma->getTraducaoByConteudo('Encomendar')->traducao);
            } elseif ($p->valorReal->num <= 0 || $p->tipoPedido == Produto::TIPO_PEDIDO_SOB_CONSULTA || $rsP['tipopedidoprodutostodosite'] == Produto::TIPO_PEDIDO_SOB_CONSULTA) {
                $iTM->enterRepeticao()->condicao('condicao->valor.Produto', false);
                $linkVisualizar .= '&consultar';
                $iTM->enterRepeticao()->trocar('acao.Produto', $idioma->getTraducaoByConteudo('Sob Consulta')->traducao);
            } else
                $iTM->enterRepeticao()->condicao('condicao->valor.Produto', true);

            $iTM->enterRepeticao()->condicao('condicao->promocao.Produto', $p->valorVenda->num < $p->valorReal->num && $p->valorVenda->num > 0);
            $iTM->enterRepeticao()->trocar('valor.Produto', "$ " . $p->valorReal->formatar());
            $iTM->enterRepeticao()->trocar('valorPromocional.Produto', "$ " . $p->valorVenda->formatar());
            $iTM->enterRepeticao()->trocar('linkPedido.Produto', Sistema::$caminhoURL . $_SESSION['lang'] . "/processar-carrinho&produto=" . $p->getId());

            $parcelas = Pedido::__ParcelasPagSeguro($p->valor->num);
            foreach ($parcelas as $k => $v) {
                $iTM->enterRepeticao()->condicao('condicao->Parcela' . $k . '.pagSeguro.valor.Produto', $v > PagamentoPagSeguro::PARCELAMINIMA && $rsP['ativopagseguro']);
                $iTM->enterRepeticao()->trocar('parcela' . $k . '.pagSeguro.valor.Produto', Numero::__CreateNumero($v)->formatar());
            }
            if ($p->getImagens()->getTotal() > 0) {
                $img = $p->getImagens()->listar("DESC", ListaImagens::DESTAQUE);
                if ($img->getImage()->nome != '') {
                    $iTM->enterRepeticao()->trocar('imagem.Produto', $img->getImage()->showHTML(270, 290));
                    $iTM->enterRepeticao()->trocar('url.Imagem.Produto', $img->getImage()->pathImage(270, 290));
                }
            }

            $iTM->enterRepeticao()->trocar('linkVisualizar.Produto', $linkVisualizar);
            $iTM->enterRepeticao()->trocar('linkAdicionar.Produto', Sistema::$caminhoURL . $_SESSION['lang'] . "/processar-carrinho&produto=" . $p->getId());

            $idp = $p->getProdutoPai() > 0 ? $p->getProdutoPai() : $p->getId();

            $sqlOpcoes = "SELECT pov.*,
							po.nome as nomeopcao,
							po.tipo,
							(SELECT u.url
								FROM " . Sistema::$BDPrefixo . "urls u
								WHERE u.tabela = 'produtos'
									AND u.valor = pog.produto) as url
						FROM " . Sistema::$BDPrefixo . "produtos_opcoes_gerados pog
						INNER JOIN " . Sistema::$BDPrefixo . "produtos_opcoes po
							ON po.id = pog.opcao
						INNER JOIN " . Sistema::$BDPrefixo . "produtos_opcoes_valores pov
							ON pov.id = pog.valor
						WHERE pog.produto IN (SELECT p.id
												FROM " . Sistema::$BDPrefixo . "produtos p
												WHERE p.id = '" . $idp . "' OR p.produtopai = '" . $idp . "')
							AND po.multi = 1
							AND po.aberto = 1
						GROUP BY pov.id
						ORDER BY nomeopcao, pov.valor ASC";
            $con->executar($sqlOpcoes);
            $iTM->enterRepeticao()->createRepeticao("repetir->ProdutoOpcoes.Produto");
            $opcao = 0;
            while ($rsPO = $con->getRegistro()) {
                if ($opcao != $rsPO['opcao']) {
                    $iTM->enterRepeticao()->repetir();
                    $iTM->enterRepeticao()->enterRepeticao()->condicao("condicao->Texto.ProdutoOpcao.Produto", $rsPO['tipo'] == 0);
                    $iTM->enterRepeticao()->enterRepeticao()->condicao("condicao->Cor.ProdutoOpcao.Produto", $rsPO['tipo'] == 2);
                    $iTM->enterRepeticao()->enterRepeticao()->trocar("nome.ProdutoOpcao.Produto", $rsPO['nomeopcao']);
                    $iTM->enterRepeticao()->enterRepeticao()->createRepeticao('repetir->ProdutoOpcaoValores.ProdutoOpcao.Produto');
                    $opcao = $rsPO['opcao'];
                }
                $iTM->enterRepeticao()->enterRepeticao()->repetir();
                $iTM->enterRepeticao()->enterRepeticao()->enterRepeticao()->trocar("valor.ProdutoOpcaoValor.ProdutoOpcao.Produto", $rsPO['valor']);
                $iTM->enterRepeticao()->enterRepeticao()->enterRepeticao()->trocar("cor.ProdutoOpcaoValor.ProdutoOpcao.Produto", $rsPO['cor']);
                $iTM->enterRepeticao()->enterRepeticao()->enterRepeticao()->trocar("linkVisualizar.ProdutoOpcaoValor.ProdutoOpcao.Produto", Sistema::$caminhoURL . $_SESSION['lang'] . '/produtos/' . (!empty($procura) ? $procura : ($cat ? $cat->getURL()->getURL() : '')) . "/" . (empty($rsPO['url']) ? $p->getURL()->url : $rsPO['url']));
            }

        }else
            $lP->setParametros($lP->getParametros('limite')+1, 'limite');

	}

}

$iTM->createRepeticao('repetir->Produtos2');

if($lP->getTotal() > 0){

	$num = 0;
	$por = 16;
	$minimo = $_GET['pag']*$por;
	$maximo = $minimo+$por;

	$lP->setParametros($lP->getParametros('limite')+8, 'limite');

	while($p = $lP->listar("DESC")){

		$num++;

        if($p->getImagens()->getTotal() > 0) {

            $iTM->repetir();

            $cat = $p->getCategorias()->listar();

            $iTM->enterRepeticao()->trocar('id.Produto', $p->getId());
            $iTM->enterRepeticao()->trocar('codigo.Produto', $p->codigo);
            $iTM->enterRepeticao()->trocar('nome.Produto', $idioma->getTraducaoById(ListaProdutos::NOME, $lP->getTabela(), $p->getId())->traducao);
            $iTM->enterRepeticao()->trocar('descricaoPequena.Produto', $idioma->getTraducaoByConteudo($p->descricaoPequena)->traducao);

            $iTM->enterRepeticao()->trocar('id.Marca.Produto', $p->getMarca()->getId());
            $iTM->enterRepeticao()->trocar('nome.Marca.Produto', $idioma->getTraducaoById(ListaProdutoMarcas::NOME, "produtos_marcas", $p->getMarca()->getId())->traducao);
            if ($p->getMarca()->getImagem()->nome != '')
                $iTM->enterRepeticao()->trocar('imagem.Marca.Produto', $p->getMarca()->getImagem()->showHTML(200, 15));
            $iTM->enterRepeticao()->trocar('linkVisualizar.Marca.Produto', Sistema::$caminhoURL . $_SESSION['lang'] . "/produtos/&marca=" . $p->getMarca()->getURL()->url);


            while ($pI = $p->getInfos()->listar()) {
                $p->estoque += $pI->estoque;
            }

            $linkVisualizar = Sistema::$caminhoURL . $_SESSION['lang'] . '/produtos/' . (!empty($procura) ? $procura : ($cat ? $cat->getURL()->url : '')) . "/" . $p->getURL()->url;
            //echo $p->nome." - ".$p->estoque."<br>";
            if ($p->estoque <= 0 && $p->tipoPedido != Produto::TIPO_PEDIDO_SOB_CONSULTA && $rsP['tipopedidoprodutostodosite'] != Produto::TIPO_PEDIDO_SOB_CONSULTA && $rsP['tiposite'] == 2 && $rsP['tipopedido'] != 1) {
                $iTM->enterRepeticao()->condicao('condicao->valor.Produto', false);
                $linkVisualizar .= '&pedido-estoque';
                $iTM->enterRepeticao()->trocar('acao.Produto', $idioma->getTraducaoByConteudo('Encomendar')->traducao);
            } elseif ($p->valorReal->num <= 0 || $p->tipoPedido == Produto::TIPO_PEDIDO_SOB_CONSULTA || $rsP['tipopedidoprodutostodosite'] == Produto::TIPO_PEDIDO_SOB_CONSULTA) {
                $iTM->enterRepeticao()->condicao('condicao->valor.Produto', false);
                $linkVisualizar .= '&consultar';
                $iTM->enterRepeticao()->trocar('acao.Produto', $idioma->getTraducaoByConteudo('Sob Consulta')->traducao);
            } else
                $iTM->enterRepeticao()->condicao('condicao->valor.Produto', true);

            $iTM->enterRepeticao()->condicao('condicao->promocao.Produto', $p->valorVenda->num < $p->valorReal->num && $p->valorVenda->num > 0);
            $iTM->enterRepeticao()->trocar('valor.Produto', "$ " . $p->valorReal->formatar());
            $iTM->enterRepeticao()->trocar('valorPromocional.Produto', "$ " . $p->valorVenda->formatar());
            $iTM->enterRepeticao()->trocar('linkPedido.Produto', Sistema::$caminhoURL . $_SESSION['lang'] . "/processar-carrinho&produto=" . $p->getId());

            $parcelas = Pedido::__ParcelasPagSeguro($p->valor->num);
            foreach ($parcelas as $k => $v) {
                $iTM->enterRepeticao()->condicao('condicao->Parcela' . $k . '.pagSeguro.valor.Produto', $v > PagamentoPagSeguro::PARCELAMINIMA && $rsP['ativopagseguro']);
                $iTM->enterRepeticao()->trocar('parcela' . $k . '.pagSeguro.valor.Produto', Numero::__CreateNumero($v)->formatar());
            }
            if ($p->getImagens()->getTotal() > 0) {
                $img = $p->getImagens()->listar("DESC", ListaImagens::DESTAQUE);
                if ($img->getImage()->nome != '') {
                    $iTM->enterRepeticao()->trocar('imagem.Produto', $img->getImage()->showHTML(270, 290));
                    $iTM->enterRepeticao()->trocar('url.Imagem.Produto', $img->getImage()->pathImage(270, 290));
                }
            }

            $iTM->enterRepeticao()->trocar('linkVisualizar.Produto', $linkVisualizar);
            $iTM->enterRepeticao()->trocar('linkAdicionar.Produto', Sistema::$caminhoURL . $_SESSION['lang'] . "/processar-carrinho&produto=" . $p->getId());

            $idp = $p->getProdutoPai() > 0 ? $p->getProdutoPai() : $p->getId();

            $sqlOpcoes = "SELECT pov.*,
							po.nome as nomeopcao,
							po.tipo,
							(SELECT u.url
								FROM " . Sistema::$BDPrefixo . "urls u
								WHERE u.tabela = 'produtos'
									AND u.valor = pog.produto) as url
						FROM " . Sistema::$BDPrefixo . "produtos_opcoes_gerados pog
						INNER JOIN " . Sistema::$BDPrefixo . "produtos_opcoes po
							ON po.id = pog.opcao
						INNER JOIN " . Sistema::$BDPrefixo . "produtos_opcoes_valores pov
							ON pov.id = pog.valor
						WHERE pog.produto IN (SELECT p.id
												FROM " . Sistema::$BDPrefixo . "produtos p
												WHERE p.id = '" . $idp . "' OR p.produtopai = '" . $idp . "')
							AND po.multi = 1
							AND po.aberto = 1
						GROUP BY pov.id
						ORDER BY nomeopcao, pov.valor ASC";
            $con->executar($sqlOpcoes);
            $iTM->enterRepeticao()->createRepeticao("repetir->ProdutoOpcoes.Produto");
            $opcao = 0;
            while ($rsPO = $con->getRegistro()) {
                if ($opcao != $rsPO['opcao']) {
                    $iTM->enterRepeticao()->repetir();
                    $iTM->enterRepeticao()->enterRepeticao()->condicao("condicao->Texto.ProdutoOpcao.Produto", $rsPO['tipo'] == 0);
                    $iTM->enterRepeticao()->enterRepeticao()->condicao("condicao->Cor.ProdutoOpcao.Produto", $rsPO['tipo'] == 2);
                    $iTM->enterRepeticao()->enterRepeticao()->trocar("nome.ProdutoOpcao.Produto", $rsPO['nomeopcao']);
                    $iTM->enterRepeticao()->enterRepeticao()->createRepeticao('repetir->ProdutoOpcaoValores.ProdutoOpcao.Produto');
                    $opcao = $rsPO['opcao'];
                }
                $iTM->enterRepeticao()->enterRepeticao()->repetir();
                $iTM->enterRepeticao()->enterRepeticao()->enterRepeticao()->trocar("valor.ProdutoOpcaoValor.ProdutoOpcao.Produto", $rsPO['valor']);
                $iTM->enterRepeticao()->enterRepeticao()->enterRepeticao()->trocar("cor.ProdutoOpcaoValor.ProdutoOpcao.Produto", $rsPO['cor']);
                $iTM->enterRepeticao()->enterRepeticao()->enterRepeticao()->trocar("linkVisualizar.ProdutoOpcaoValor.ProdutoOpcao.Produto", Sistema::$caminhoURL . $_SESSION['lang'] . '/produtos/' . (!empty($procura) ? $procura : ($cat ? $cat->getURL()->getURL() : '')) . "/" . (empty($rsPO['url']) ? $p->getURL()->url : $rsPO['url']));
            }

        }else
            $lP->setParametros($lP->getParametros('limite')+1, 'limite');

	}

}

//include('lateral-direita.php');
//$iTM->trocar('lateralDireita', $lateralDireita);

$javaScript .= $iTM->createJavaScript()->concluir();

$includePagina = $iTM->concluir();

?>