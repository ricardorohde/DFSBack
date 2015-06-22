<?php

importar("Utilidades.Publicidades.Banners.Lista.ListaBannerCategorias");
importar("LojaVirtual.Pedidos.Pagamentos.PagamentoPagSeguro");
importar("LojaVirtual.Categorias.Lista.ListaProdutoCategorias");
importar("LojaVirtual.Produtos.ProdutoBusca");

$iTM = new InterFaces(new Arquivos(Sistema::$layoutCaminhoDiretorio."produtos.html"));

$iTM->setSESSION($_SESSION);
$iTM->trocar('lang', $_SESSION['lang']);

//metatag
$titulo = $idioma->getTraducaoByConteudo("Novidades")->traducao;
$descricao = $idioma->getTraducaoByConteudo("Novidades")->traducao;
//

include('lateral-esquerda.php');
$iTM->trocar('lateralEsquerda', $lateralEsquerda);

$iTM->trocar('titulo', "Novidades");

unset($aR);
$aR[1] = array('campo' => ListaProdutos::DISPONIVEL, 'valor' => ListaProdutos::VALOR_DISPONIVEL_TRUE);
$aR[2] = array('campo' => ListaProdutos::LANCAMENTO, 'valor' => ListaProdutos::VALOR_DISPONIVEL_TRUE);

$lP = new ListaProdutos;
$lP->condicoes($aR);

$iTM->condicao('condicao->Produtos', !empty($rs));
$iTM->createRepeticao('repetir->Paginador.Produto');
$iTM->createRepeticao('repetir->Produtos');

if($lP->getTotal() > 0){
	
	$con = BDConexao::__Abrir();
	$con->executar("SELECT * FROM ".Sistema::$BDPrefixo."pagamentos");
	$rsP = $con->getRegistro();
	
	$num = 0;
	$por = 15;
	$minimo = $_GET['pag']*$por;
	$maximo = $minimo+$por;
	
	$lP->setParametros($maximo, 'limite')->setParametros($minimo);
	
	while($p = $lP->listar()){
		
		$num++;
			
		$iTM->repetir();
		
		$cat = $p->getCategorias()->listar();
		
		$iTM->enterRepeticao()->trocar('id.Produto', $p->getId());
		$iTM->enterRepeticao()->trocar('codigo.Produto', $p->codigo);
		$iTM->enterRepeticao()->trocar('nome.Produto', $idioma->getTraducaoById(ListaProdutos::NOME, $lP->getTabela(), $p->getId())->traducao);
		$iTM->enterRepeticao()->trocar('descricao.Produto',  $idioma->getTraducaoByConteudo($p->descricao)->traducao);
		$iTM->enterRepeticao()->trocar('descricaoPequena.Produto',  $idioma->getTraducaoByConteudo($p->descricaoPequena)->traducao);
		
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
		$iTM->enterRepeticao()->trocar('valor.Produto',  "U$ ".$p->valorReal->moeda());
		$iTM->enterRepeticao()->trocar('valorPromocional.Produto',  "U$ ".$p->valorVenda->moeda());
		$iTM->enterRepeticao()->trocar('linkPedido.Produto',  Sistema::$caminhoURL.$_SESSION['lang']."/processar-carrinho&produto=".$p->getId());
		
		$parcelas = Pedido::__ParcelasPagSeguro($p->valor->num);
		foreach($parcelas as $k => $v){
			$iTM->enterRepeticao()->condicao('condicao->Parcela'.$k.'.pagSeguro.valor.Produto',  $v > PagamentoPagSeguro::PARCELAMINIMA && $rsP['ativopagseguro']);
			$iTM->enterRepeticao()->trocar('parcela'.$k.'.pagSeguro.valor.Produto',  Numero::__CreateNumero($v)->moeda());
		}
		if($p->getImagens()->getTotal() > 0){
			$img = $p->getImagens()->listar("DESC", ListaImagens::DESTAQUE);
			if($img->getImage()->nome != ''){
				$iTM->enterRepeticao()->trocar('imagem.Produto', $img->getImage()->showHTML(242, 200));
				$iTM->enterRepeticao()->trocar('url.Imagem.Produto', $img->getImage()->pathImage(242, 200));
			}
		}
		
		$iTM->enterRepeticao()->trocar('linkVisualizar.Produto', $linkVisualizar);
		
		$idp = $p->getProdutoPai() > 0 ? $p->getProdutoPai() : $p->getId();

		
	}
	
}

$javaScript .= $iTM->createJavaScript()->concluir();

$includePagina = $iTM->concluir();

?>