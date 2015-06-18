<?php

importar("Utilidades.Publicidades.Banners.Lista.ListaBannerCategorias");
importar("LojaVirtual.Pedidos.Pagamentos.PagamentoPagSeguro");
importar("LojaVirtual.Categorias.Lista.ListaProdutoCategorias");
importar("LojaVirtual.Produtos.ProdutoBusca");

$iTM = new InterFaces(new Arquivos(Sistema::$layoutCaminhoDiretorio."produtos.html"));

$iTM->setSESSION($_SESSION);
$iTM->trocar('lang', $_SESSION['lang']);

//metatag
$titulo = $idioma->getTraducaoByConteudo("Ofertas")->traducao;
$descricao = $idioma->getTraducaoByConteudo("Ofertas")->traducao;

$iTM->trocar('titulo',$titulo);

//
$con = BDConexao::__Abrir();
$con->executar("SELECT * FROM ".Sistema::$BDPrefixo."produtos_configuracoes");
$rsPR = $con->getRegistro();
$con->close();

include('lateral-esquerda.php');
$iTM->trocar('lateralEsquerda', $lateralEsquerda);

/*$lBC = new ListaBannerCategorias;
$lBC->condicoes("", 1, ListaBannerCategorias::ID);
if($lBC->getTotal() > 0){
	$bC = $lBC->listar();
	
	$dT = new DataHora;
	$aR[1] = array('campo' => ListaBanners::ATIVO, 		'valor' => ListaBanners::VALOR_ATIVO_TRUE);
	$bC->getBanners()->condicoes($aR);
	
	if($bC->getBanners()->getTotal() > 0){
		while($b = $bC->getBanners()->listar("DESC", "rand()")){
			
			if($b->getDataInicio()->mostrar("YmdHi") == $b->getDataFim()->mostrar("YmdHi") || ($b->getDataInicio()->mostrar("YmdHi") <= $dT->mostrar("YmdHi") && $b->getDataFim()->mostrar("YmdHi") >= $dT->mostrar("YmdHi"))){
				$iTM->trocar("imagem.Banner", $b->getImagem()->showHTML(990, 1000));
				$iTM->trocar("enderecoURL.Banner", $b->enderecoURL);
			}
			
		}
	}
		
}*/


unset($aR);
$aR[1] = array('campo' => ListaProdutos::DISPONIVEL, 'valor' => ListaProdutos::VALOR_DISPONIVEL_TRUE);
$aR[2] = array('campo' => ListaProdutos::REMOVIDO, 'valor' => ListaProdutos::VALOR_DISPONIVEL_FALSE);
$aR[3] = array('campo' => ListaProdutos::PRODUTOPAI, 'valor' => '');

$lP = new ListaProdutos;
$lP->condicoes($aR);

$iTM->condicao('condicao->Produtos', $lP->getTotal() > 0);
$iTM->createRepeticao('repetir->Paginador.Produto');
$iTM->createRepeticao('repetir->Produtos');

if($lP->getTotal() > 0){
	
	$con = BDConexao::__Abrir();
	$con->executar("SELECT * FROM ".Sistema::$BDPrefixo."pagamentos");
	$rsP = $con->getRegistro();

    $num = 0;
    $por = $rsPR['produtosporsubcategoria'];
    $paginas = 10;
    $minimo = $_GET['pag']*$por;
    $maximo = $minimo+$por;

    $lP->setParametros($maximo, 'limite')->setParametros($minimo);

    $i=0;
	while($p = $lP->listar()){
		
		$num++;

		$iTM->repetir();
		
		$cat = $p->getCategorias()->listar();

        $iTM->enterRepeticao()->condicao('condicao->BreakLine', $i>=3);
        if($i >= 3){
            $i=0;
        }
		
		$iTM->enterRepeticao()->trocar('id.Produto', $p->getId());
		$iTM->enterRepeticao()->trocar('codigo.Produto', $p->codigo);
		$iTM->enterRepeticao()->trocar('nome.Produto', $idioma->getTraducaoById(ListaProdutos::NOME, $lP->getTabela(), $p->getId())->traducao);
		$iTM->enterRepeticao()->trocar('descricao.Produto',  $idioma->getTraducaoByConteudo($p->descricao)->traducao);
		
		$iTM->enterRepeticao()->trocar('id.Marca.Produto', $p->getMarca()->getId());
		$iTM->enterRepeticao()->trocar('nome.Marca.Produto', $idioma->getTraducaoById(ListaProdutoMarcas::NOME, "produtos_marcas", $p->getMarca()->getId())->traducao);
		$iTM->enterRepeticao()->trocar('linkVisualizar.Marca.Produto', Sistema::$caminhoURL.$_SESSION['lang']."/produtos/".$p->getMarca()->getURL()->url);
		
		
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
		$iTM->enterRepeticao()->trocar('valor.Produto',  "R$ ".$p->valorReal->moeda());
		$iTM->enterRepeticao()->trocar('valorPromocional.Produto',  "R$ ".$p->valorVenda->moeda());
		$iTM->enterRepeticao()->trocar('linkPedido.Produto',  Sistema::$caminhoURL.$_SESSION['lang']."/processar-carrinho&produto=".$p->getId());
		
		$parcelas = Pedido::__ParcelasPagSeguro($p->valor->num);
		foreach($parcelas as $k => $v){
			$iTM->enterRepeticao()->condicao('condicao->Parcela'.$k.'.pagSeguro.valor.Produto',  $v > PagamentoPagSeguro::PARCELAMINIMA && $rsP['ativopagseguro']);
			$iTM->enterRepeticao()->trocar('parcela'.$k.'.pagSeguro.valor.Produto',  Numero::__CreateNumero($v)->moeda());
		}
		if($p->getImagens()->getTotal() > 0){
			$img = $p->getImagens()->listar("DESC", ListaImagens::DESTAQUE);
			if($img->getImage()->nome != ''){
				$iTM->enterRepeticao()->trocar('imagem.Produto', $img->getImage()->showHTML(194, 207));
				$iTM->enterRepeticao()->trocar('url.Imagem.Produto', $img->getImage()->pathImage(194, 207));
			}
		}
		
		$iTM->enterRepeticao()->trocar('linkVisualizar.Produto', $linkVisualizar);
		
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

	}

    $total = $lP->getTotal();


    //Paginador
    $max = number_format($total/$por);
    if($max < $total/$por) $max++;
    if($max > $paginas){
        $paginas2 = (int) ($paginas/2);
        $inicioPaginas = (($_GET['pag']+1)-$paginas2 < 1) ? 1 : (is_float($paginas/2) ? ($_GET['pag']+1)-($paginas2) : ($_GET['pag']+1)-($paginas2-1));
        $fimPaginas = ($inicioPaginas+$paginas-1 > $max) ? $max : $inicioPaginas+$paginas-1;
        $inicioPaginas += (($_GET['pag']+1) > $fimPaginas-($paginas2) && is_float($paginas/2)) ? ($fimPaginas-$paginas2)-($_GET['pag']+1) : 0;
    }else{
        $inicioPaginas = 1;
        $fimPaginas = $max;
    }

    $iTM->condicao('condicao->Paginador.Topo.Produtos', $max > 1);
    $iTM->condicao('condicao->Paginador.Rodape.Produtos', $max > 1);
    $iTM->createRepeticao('repetir->Paginador.Topo.Produtos');
    $iTM->createRepeticao('repetir->Paginador.Rodape.Produtos');

    //Filtros
    $urlFiltros = '';
    if(count($arrayFiltros) > 0){
        $existefiltroarray = false;
        foreach($arrayFiltros as $k => $v)
            $urlFiltros .= '&filtro'.$k.'='.$v;
    }
    //

    for($i = $inicioPaginas; $i <= $fimPaginas; $i++){
        $iTM->repetir('repetir->Paginador.Topo.Produtos');
        $iTM->repetir('repetir->Paginador.Rodape.Produtos');

        $iTM->enterRepeticao('repetir->Paginador.Topo.Produtos')->condicao('condicao->Selecionada.Pagina.Produtos', $i-1 == $_GET['pag']);
        $iTM->enterRepeticao('repetir->Paginador.Topo.Produtos')->trocar('numero.Pagina.Produtos', $i);
        $iTM->enterRepeticao('repetir->Paginador.Topo.Produtos')->trocar('linkVisualizar.Pagina.Produtos', Sistema::$caminhoURL.$_SESSION['lang']."/ofertas".(!empty($procura) ? "/".$procura."/" : '/')."&pag=".($i-1)."&busca=".$_GET['busca']."&marca=".$_GET['marca']."&order=".$_GET['order'].$urlFiltros);

        $iTM->enterRepeticao('repetir->Paginador.Rodape.Produtos')->condicao('condicao->Selecionada.Pagina.Produtos', $i-1 == $_GET['pag']);
        $iTM->enterRepeticao('repetir->Paginador.Rodape.Produtos')->trocar('numero.Pagina.Produtos', $i);
        $iTM->enterRepeticao('repetir->Paginador.Rodape.Produtos')->trocar('linkVisualizar.Pagina.Produtos', Sistema::$caminhoURL.$_SESSION['lang']."/ofertas".(!empty($procura) ? "/".$procura."/" : '/')."&pag=".($i-1)."&busca=".$_GET['busca']."&marca=".$_GET['marca']."&order=".$_GET['order'].$urlFiltros);

    }

    $ant = ($_GET['pag']-1);
    $prox = ($_GET['pag']+1);

    $iTM->condicao('condicao->Anterior.Paginador.Topo.Produtos', $ant < 0);
    $iTM->condicao('condicao->Proximo.Paginador.Topo.Produtos', $_GET['pag']+1 < $max);
    $iTM->trocar('linkVisualizar.Anterior.Paginador.Topo.Produtos', Sistema::$caminhoURL.$_SESSION['lang']."/ofertas".(!empty($procura) ? "/".$procura."/" : '/')."&pag=".($_GET['pag']-1)."&busca=".$_GET['busca']."&marca=".$_GET['marca']."&order=".$_GET['order'].$urlFiltros);
    $iTM->trocar('linkVisualizar.Proximo.Paginador.Topo.Produtos', Sistema::$caminhoURL.$_SESSION['lang']."/ofertas".(!empty($procura) ? "/".$procura."/" : '/')."&pag=".($_GET['pag']+1)."&busca=".$_GET['busca']."&marca=".$_GET['marca']."&order=".$_GET['order'].$urlFiltros);

    $iTM->condicao('condicao->Anterior.Paginador.Rodape.Produtos', $_GET['pag']+1 > 1);
    $iTM->condicao('condicao->Proximo.Paginador.Rodape.Produtos', $prox >= $max);
    $iTM->trocar('linkVisualizar.Anterior.Paginador.Rodape.Produtos', Sistema::$caminhoURL.$_SESSION['lang']."/ofertas".(!empty($procura) ? "/".$procura."/" : '/')."&pag=".($_GET['pag']-1)."&busca=".$_GET['busca']."&marca=".$_GET['marca']."&order=".$_GET['order'].$urlFiltros);
    $iTM->trocar('linkVisualizar.Proximo.Paginador.Rodape.Produtos', Sistema::$caminhoURL.$_SESSION['lang']."/ofertas".(!empty($procura) ? "/".$procura."/" : '/')."&pag=".($_GET['pag']+1)."&busca=".$_GET['busca']."&marca=".$_GET['marca']."&order=".$_GET['order'].$urlFiltros);


}

$javaScript .= $iTM->createJavaScript()->concluir();

$includePagina = $iTM->concluir();

?>