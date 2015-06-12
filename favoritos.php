<?php

importar("Utilidades.Publicidades.Banners.Lista.ListaBannerCategorias");
importar("LojaVirtual.Pedidos.Pagamentos.PagamentoPagSeguro");
importar("LojaVirtual.Categorias.Lista.ListaProdutoCategorias");
importar("LojaVirtual.Produtos.ProdutoBusca");

$iTM = new InterFaces(new Arquivos(Sistema::$layoutCaminhoDiretorio."produtos.html"));

$iTM->setSESSION($_SESSION);
$iTM->trocar('lang', $_SESSION['lang']);

//metatag
$titulo = $idioma->getTraducaoByConteudo("Meus Favoritos")->traducao;
$descricao = $idioma->getTraducaoByConteudo("Meus Favoritos")->traducao;
//

//include('lateral-esquerda.php');
//$iTM->trocar('lateralEsquerda', $lateralEsquerda);

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


$lP = new ListaProdutos;
$iTM->condicao('condicao->Produtos', !empty($_COOKIE['favoritos']));
$iTM->condicao('condicao->ProdutoCategorias', false);
$iTM->condicao('condicao->Paginador.Produtos', false);
$iTM->createRepeticao('repetir->Paginador.Produto');
$iTM->createRepeticao('repetir->Produtos');
$iTM->trocar('navegador.ProdutoCategoria', $idioma->getTraducaoByConteudo('Meus Favoritos')->traducao);

if(count($_COOKIE['favoritos']) > 0){
	
	$con = BDConexao::__Abrir();
	$con->executar("SELECT * FROM ".Sistema::$BDPrefixo."pagamentos");
	$rsP = $con->getRegistro();
	
	$num = 0;
	$por = 999;
	$minimo = $_GET['pag']*$por;
	$maximo = $minimo+$por;
	
	$lP->setParametros($maximo, 'limite')->setParametros($minimo);
	
	$array = array_reverse($_COOKIE['favoritos']);
	$array = array_unique($array);
	foreach($array as $k){
		
		$lP->condicoes('', $k, ListaProdutos::ID);
		$p = $lP->listar();
		$num++;
			
		$iTM->repetir();
		
		$cat = $p->getCategorias()->listar();
		
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
				$iTM->enterRepeticao()->trocar('imagem.Produto', $img->getImage()->showHTML(190, 207));
				$iTM->enterRepeticao()->trocar('url.Imagem.Produto', $img->getImage()->pathImage(190, 207));
			}
		}
		
		$iTM->enterRepeticao()->trocar('linkVisualizar.Produto', $linkVisualizar);
		
	}
	
}

$javaScript .= $iTM->createJavaScript()->concluir();

$includePagina = $iTM->concluir();

?>