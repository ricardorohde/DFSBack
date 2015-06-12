<?php

importar("LojaVirtual.Categorias.Lista.ListaProdutoCategorias");
importar("LojaVirtual.Produtos.ProdutoBusca");

if(!empty($procura2)){

	include('detalhes.php');

}else{
	
	$iTP = new InterFaces(new Arquivos(Sistema::$layoutCaminhoDiretorio."produtos.html"));

	$iTP->setSESSION($_SESSION);

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
	
	$pCP->setSession($_SESSION);
		
	$nav 	= $pCP->getNavegador(new Templates(Arquivos::__Create("{nome}")));
	$iTP->trocar('navegador.ProdutoCategoria', 'Ofertas');
	$iTP->trocar('descricao.ProdutoCategoria', $idioma->getTraducaoByConteudo($pCP->descricao)->traducao);
	
	if(!empty($_SESSION['usuario']))
		$lancamento = 1;
	else
		$lancamento = 0;
	
	$rs 	= ProdutoBusca::buscaUmaCategoria($pCP, "AND p.disponivel = '".ListaProdutos::VALOR_DISPONIVEL_TRUE."' AND destaque = '".ListaProdutos::VALOR_DISPONIVEL_TRUE."'");
	
	$iTP->condicao('condicao->ProdutoCategorias', $pCP->getSubCategorias()->getTotal() > 0);
	
	if(!empty($pCP->nome))
		$iTP->trocar('traduzir->Produtos', $idioma->getTraducaoByConteudo($pCP->nome)->traducao);

	$iTP->createRepeticao("repetir->ProdutoCategorias");
	
	if($pCP->getIdCategoriaPai() == 7)
		$pCP = new ProdutoCategoria(7);
	
	$filtros = '';
	while($pC = $pCP->getSubCategorias()->listar()){
		
		$iTP->repetir();
		$iTP->enterRepeticao()->trocar('nome.ProdutoCategoria', $idioma->getTraducaoByConteudo($pC->nome)->traducao);
		if(!empty($pC->getImagem()->nome))
			$iTP->enterRepeticao()->trocar('imagem.ProdutoCategoria', $pC->getImagem()->showHTML(20, 20));
			
		$iTP->enterRepeticao()->trocar('linkVisualizar.ProdutoCategoria', Sistema::$caminhoURL.$_SESSION['lang'].'/'.$pagina.'/'.$pC->getURL()->url);
		
		if(!empty($pC->getImagem()->nome))
		$filtros .= '<a href="'.Sistema::$caminhoURL.$_SESSION['lang'].'/'.$pagina.'/'.$pC->getURL()->url.'">'.$pC->getImagem()->showHTML(20, 20, $pC->nome).'</a>';
		$iTP->enterRepeticao()->createRepeticao("repetir->ProdutoCategorias.ProdutoCategoria");
		
	}
	
	if($filtros)
		$filtros = '<div class="filtros"><div>Filtrar por cor:</div> '.$filtros.'</div>';
	
	$iTP->trocar('filtros', $filtros);
	
	$iTP->condicao('condicao->Produtos', !empty($rs));
	$iTP->createRepeticao('repetir->Produtos');
	
	if(!empty($rs)){
		
		$lP = new ListaProdutos;
		$num = 0;
		$por = 30;
		$minimo = $_GET['pag']*$por;
		$maximo = $minimo+$por;
		foreach($rs as $p){
			
			$num++;
		
			if($num > $maximo) break;
			
			if($num > $minimo){
				if($p->getImagens()->getTotal() > 0){
					$iTP->repetir();
					
					$cat = $p->getCategorias()->listar();
					
					$iTP->enterRepeticao()->trocar('id.Produto', $p->getId());
					$iTP->enterRepeticao()->trocar('codigo.Produto', $p->codigo);
					$iTP->enterRepeticao()->trocar('nome.Produto', $idioma->getTraducaoByConteudo($p->nome)->traducao);
					$iTP->enterRepeticao()->trocar('descricao.Produto',  $idioma->getTraducaoByConteudo($p->descricao)->traducao);
					
					while($pI = $p->getInfos()->listar()){
						$p->estoque += $pI['estoque'];
					}
					
					$linkVisualizar = Sistema::$caminhoURL.$_SESSION['lang'].'/produtos/'.(!empty($procura) ? $procura : $cat->getURL()->getURL())."/".$p->getURL()->url;
					if($p->estoque <= 0){
						$iTP->enterRepeticao()->condicao('condicao->valor.Produto', false);
						$iTP->enterRepeticao()->condicao('condicao->valor0.Produto', true);
						$linkVisualizar .= '&pedido-estoque';
						$iTP->enterRepeticao()->trocar('acao.Produto', 'Encomendar');
					}elseif($p->valorReal->num <= 0){
						$iTP->enterRepeticao()->condicao('condicao->valor.Produto', false);
						$iTP->enterRepeticao()->condicao('condicao->valor0.Produto', true);
						$linkVisualizar .= '&consultar';
						$iTP->enterRepeticao()->trocar('acao.Produto', 'Sob Consulta');
					}else{
						$iTP->enterRepeticao()->condicao('condicao->valor.Produto', true);
						$iTP->enterRepeticao()->condicao('condicao->valor0.Produto', false);
					}
					
					$iTP->enterRepeticao()->trocar('valor.Produto',  "R$ ".$p->valorReal->moeda());
					$iTP->enterRepeticao()->trocar('linkPedido.Produto',  Sistema::$caminhoURL.$_SESSION['lang']."/processar-carrinho&produto=".$p->getId());
					
					$img = $p->getImagens()->listar("DESC", ListaImagens::DESTAQUE);
					if($img->getImage()->nome != ''){
						$iTP->enterRepeticao()->trocar('url.Imagem.Produto', $img->getImage()->pathImage(170, 170));
					}
					
					$iTP->enterRepeticao()->trocar('linkVisualizar.Produto', $linkVisualizar);
				}
				
			}
			
		}
		
		$rep = 'repetir->Paginador.Produto';
		$max = number_format(count($rs)/$por);
		if($max < count($rs)/$por) $max++;
		$iTP->condicao('condicao->Paginador.Produtos', $max > 1);
		$iTP->createRepeticao('repetir->Paginador.Produto');
		for($i = 1; $i <= $max; $i++){
			
			$iTP->repetir($rep);
			
			$iTP->enterRepeticao($rep)->trocar('numero.Pagina.Produto', $i);
			$iTP->enterRepeticao($rep)->trocar('linkVisualizar.Pagina.Produto', Sistema::$caminhoURL.$_SESSION['lang']."/produtos".(!empty($procura) ? "/".$procura."/" : '/')."&pag=".($i-1));
			
		}
		
	}
	
	$javaScript .= $iTP->createJavaScript()->concluir();
	
	$includePagina = $iTP->concluir();
	
}

?>