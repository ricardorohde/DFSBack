<?php
importar("LojaVirtual.Categorias.Lista.ListaProdutoCategorias");
importar("LojaVirtual.Produtos.ProdutoBusca");


if(!empty($procura2)){

	include('detalhes.php');

}else{
	
	$iTP = new InterFaces(new Arquivos(Sistema::$layoutCaminhoDiretorio."produtos.html"));

	$iTP->setSESSION($_SESSION);
	$iTP->trocar('lang', $_SESSION['lang']);
	
	if(empty($_GET['busca']))
		$_GET['busca'] = '';
	
	include('lateral-esquerda.php');
	$iTP->trocar('lateralEsquerda', $lateralEsquerda);
	
	$con = BDConexao::__Abrir();
	$con->executar("SELECT * FROM ".Sistema::$BDPrefixo."produtos_configuracoes");
	$rsPR = $con->getRegistro();
	$con->close();
	
	$lPM = new ListaProdutoMarcas;
	if(!empty($_GET['marca'])){
		$lU = new ListaURLs;
		
		$cond[1] = array('campo' => ListaURLs::URL, 	'valor' => $_GET['marca']);
		$cond[2] = array('campo' => ListaURLs::TABELA, 	'valor' => $lPM->getTabela());
		
		if($lU->condicoes($cond)->getTotal() > 0){
			$lPM->condicoes('', $lU->listar()->valor, ListaProdutoMarcas::ID);
		}
	
	}
	if($lPM->getTotal() > 0) {
        $pM = $lPM->listar();
        $iTP->trocar('titulo',$idioma->getTraducaoByConteudo($pM->nome)->traducao);
    }else
		$pM 	= new ProdutoMarca;	
	$lPM->close();
	
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
	
	$lPC->close();
	
	$pCP->setSession($_SESSION);
		
	$nav 	= $pCP->getNavegador(new Templates(Arquivos::__Create("<li><a href='".Sistema::$caminhoURL.$_SESSION['lang'].'/'.$pagina.'/{url}'."'>{nome} </a></li>")), "");
	
	//metatag
	$titulo = strip_tags($nav);
	$descricao = $pCP->descricao;
	//

    $iTP->trocar('titulo',$idioma->getTraducaoByConteudo($titulo)->traducao);
    $iTP->trocar('descricao.ProdutoCategoria', $idioma->getTraducaoByConteudo($pCP->descricao)->traducao);
	
	if(!empty($_SESSION['usuario']))
		$lancamento = 1;
	else
		$lancamento = 0;
	
	unset($aPC);
	$aPC[1] = array('campo' => ListaProdutoCategorias::DISPONIVEL, 'valor' => ListaProdutoCategorias::VALOR_DISPONIVEL_TRUE);
	$pCP->getSubCategorias()->condicoes($aPC);
	
	if($pCP->getSubCategorias()->getTotal() > 0 && $rsPR['listasubcategorias'] == 1 && empty($_GET['busca'])){
		
		$iTP->condicao('condicao->ProdutoCategorias', $pCP->getSubCategorias()->getTotal() > 0);
		$iTP->createRepeticao("repetir->ProdutoCategorias");
		
		$filtros = '';
		while($pC = $pCP->getSubCategorias()->listar()){
			
			$allCat = $pC->getIdAllSubCategoria();
			$sqlCat = '';
			for($i = 0; $i < count($allCat); $i++){
				$sqlCat .= $allCat[$i];
				if($i < count($allCat)-1)
					$sqlCat .= ', ';
			}
			
			$sqlFiltros = '';
			foreach($arrayFiltros as $k => $v){
				$sqlFiltros .= "AND (SELECT COUNT(pog.id) FROM ".Sistema::$BDPrefixo."produtos_opcoes_gerados pog WHERE pog.opcao = '".$k."' AND pog.valor = '".$v."' AND pog.produto = p.id) > 0 ";
			}
			
			$sql = "SELECT a.id 
					FROM ((SELECT p.id 
							FROM ".Sistema::$BDPrefixo."produtos p 
							LEFT OUTER JOIN ".Sistema::$BDPrefixo."relacionamento_produtos_categorias rpc
								ON p.id = rpc.produto
							WHERE ".(!empty($sqlCat) ? "rpc.categoria IN 
									(".$sqlCat.")
								AND " : '')."p.".ListaProdutos::DISPONIVEL." = '".ListaProdutos::VALOR_DISPONIVEL_TRUE."' 
								".$sqlFiltros.
								"AND 
									(p.".ListaProdutos::CODIGO." = '".str_replace(" ", "%", $_GET['busca'])."' 
									OR p.".ListaProdutos::NOME." LIKE '%".str_replace(" ", "%", $_GET['busca'])."%' 
									OR p.".ListaProdutos::DESCRICAO." LIKE '%".str_replace(" ", "%", $_GET['busca'])."%') 
								".($pM->getId() != '' ? "AND 
									p.".ListaProdutos::MARCA." = ".$pM->getId() : '').")
					UNION
					(SELECT p.id
							FROM ".Sistema::$BDPrefixo."produtos p 
							INNER JOIN ".Sistema::$BDPrefixo."produtos p2
								ON p2.id = p.produtopai
							LEFT OUTER JOIN ".Sistema::$BDPrefixo."relacionamento_produtos_categorias rpc
								ON p.produtopai = rpc.produto
							WHERE ".(!empty($sqlCat) ? "rpc.categoria IN 
									(".$sqlCat.")
								AND " : '')."p2.".ListaProdutos::DISPONIVEL." = '".ListaProdutos::VALOR_DISPONIVEL_TRUE."' 
								".$sqlFiltros.
								"AND 
									(p.".ListaProdutos::CODIGO." = '".str_replace(" ", "%", $_GET['busca'])."'
									OR p2.".ListaProdutos::CODIGO." = '".str_replace(" ", "%", $_GET['busca'])."' 
									OR p.".ListaProdutos::NOME." LIKE '%".str_replace(" ", "%", $_GET['busca'])."%' 
									OR p2.".ListaProdutos::NOME." LIKE '%".str_replace(" ", "%", $_GET['busca'])."%' 
									OR p.".ListaProdutos::DESCRICAO." LIKE '%".str_replace(" ", "%", $_GET['busca'])."%'
									OR p2.".ListaProdutos::DESCRICAO." LIKE '%".str_replace(" ", "%", $_GET['busca'])."%')
								".($pM->getId() != '' ? "AND 
									p.".ListaProdutos::MARCA." = ".$pM->getId() : '').")) a";
									
			$sql = "SELECT p.*, IF(p.nome='', (SELECT p2.nome FROM ".Sistema::$BDPrefixo."produtos p2 WHERE p2.id = p.produtopai), p.nome) as nome, IF(p.valorreal<=0, (SELECT p2.valorreal FROM ".Sistema::$BDPrefixo."produtos p2 WHERE p2.id = p.produtopai), p.valorreal) as valorreal FROM ".Sistema::$BDPrefixo."produtos p WHERE p.id IN (".$sql.") AND p.produtopai NOT IN (".$sql.")";
			
			$lP = new ListaProdutos;
			$lP->condicoes('', '', '', '', $sql);
			$total = $lP->getTotal();
			
			if($total > 0){
			
				$iTP->repetir();
				
				$iTP->enterRepeticao()->trocar('navegador.ProdutoCategoria', !empty($nav) ? "<li><a href='".Sistema::$caminhoURL.$_SESSION['lang'].'/'.$pagina."'>".$idioma->getTraducaoByConteudo('Produtos')->traducao."</a>".'</li> '.$nav : "<li class='active'>".$idioma->getTraducaoByConteudo('Produtos')->traducao."</li>");
				
				$iTP->enterRepeticao()->trocar('nome.ProdutoCategoria', $idioma->getTraducaoByConteudo($pC->nome)->traducao);
				if(!empty($pC->getImagem()->nome))
					$iTP->enterRepeticao()->trocar('imagem.ProdutoCategoria', $pC->getImagem()->showHTML(20, 20));
					
				$iTP->enterRepeticao()->trocar('linkVisualizar.ProdutoCategoria', Sistema::$caminhoURL.$_SESSION['lang'].'/'.$pagina.'/'.$pC->getURL()->url);
					
				$iTP->enterRepeticao()->condicao('condicao->Produtos', $total > 0);
				$iTP->enterRepeticao()->createRepeticao('repetir->Produtos');

				$con = BDConexao::__Abrir();
				$con->executar("SELECT * FROM ".Sistema::$BDPrefixo."pagamentos");
				$rsP = $con->getRegistro();
							
				$num = 0;
				$por = $rsPR['produtosporsubcategoria'];
				$paginas = 10;
				$minimo = $_GET['pag'.$pC->getId()]*$por;
				$maximo = $minimo+$por;
				
				$lP->setParametros($minimo)->setParametros($maximo, 'limite');

                $i=0;
				while($p = $lP->listar("ASC", ListaProdutos::NOME)){
					$i++;
					$num++;
							
					$iTP->enterRepeticao()->repetir();
					
					$cat = $p->getCategorias()->listar();
					
					$iTP->enterRepeticao()->enterRepeticao()->trocar('id.Produto', $p->getId());
					$iTP->enterRepeticao()->enterRepeticao()->trocar('codigo.Produto', $p->codigo);
					$nome = $idioma->getTraducaoById(ListaProdutos::NOME, $lP->getTabela(), $p->getId())->traducao;
					$nome = !empty($nome) ? $nome : $idioma->getTraducaoById(ListaProdutos::NOME, $lP->getTabela(), $p->getProdutoPai())->traducao;
					$iTP->enterRepeticao()->enterRepeticao()->trocar('nome.Produto', $nome);
					$iTP->enterRepeticao()->enterRepeticao()->trocar('descricao.Produto',  $idioma->getTraducaoByConteudo($p->descricao)->traducao);
					$iTP->enterRepeticao()->enterRepeticao()->trocar('descricaoPequena.Produto',  $idioma->getTraducaoByConteudo($p->descricaoPequena)->traducao);
					
					$iTP->enterRepeticao()->enterRepeticao()->trocar('id.Marca.Produto', $p->getMarca()->getId());
					$iTP->enterRepeticao()->enterRepeticao()->trocar('nome.Marca.Produto', $idioma->getTraducaoById(ListaProdutoMarcas::NOME, "produtos_marcas", $p->getMarca()->getId())->traducao);
					if($p->getMarca()->getImagem()->nome != '')
						$iTP->enterRepeticao()->enterRepeticao()->trocar('imagem.Marca.Produto', $p->getMarca()->getImagem()->showHTML(200, 15));
					$iTP->enterRepeticao()->enterRepeticao()->trocar('linkVisualizar.Marca.Produto', Sistema::$caminhoURL.$_SESSION['lang']."/produtos/&marca=".$p->getMarca()->getURL()->url);
					
					$linkPedido = true;
					while($pI = $p->getInfos()->listar()){
						$p->estoque += $pI->estoque;
						if($pI->estoque > 0)
							$linkPedido = false;
					}
					
					$linkVisualizar = Sistema::$caminhoURL.$_SESSION['lang'].'/produtos/'.$pC->getURL()->url."/".$p->getURL()->url;
					if($p->estoque <= 0 && $p->tipoPedido != Produto::TIPO_PEDIDO_SOB_CONSULTA && $rsP['tipopedidoprodutostodosite'] != Produto::TIPO_PEDIDO_SOB_CONSULTA && $rsP['tiposite'] == 2 && $rsP['tipopedido'] != 1){
						$iTP->enterRepeticao()->enterRepeticao()->condicao('condicao->valor.Produto', false);
						$linkVisualizar .= '&pedido-estoque';
						$iTP->enterRepeticao()->enterRepeticao()->trocar('acao.Produto', $idioma->getTraducaoByConteudo('Encomendar')->traducao);
					}elseif(($p->getMarca()->getId() == 182) || ($p->valorReal->num <= 0 || $p->tipoPedido == Produto::TIPO_PEDIDO_SOB_CONSULTA || $rsP['tipopedidoprodutostodosite'] == Produto::TIPO_PEDIDO_SOB_CONSULTA) || preg_match("!relojes!", $procura)){
						$iTP->enterRepeticao()->enterRepeticao()->condicao('condicao->valor.Produto', false);
						$linkVisualizar .= '&consultar';
						$iTP->enterRepeticao()->enterRepeticao()->trocar('acao.Produto', $idioma->getTraducaoByConteudo('Sob Consulta')->traducao);
					}else
						$iTP->enterRepeticao()->enterRepeticao()->condicao('condicao->valor.Produto', true);
					
					$iTP->enterRepeticao()->enterRepeticao()->condicao('condicao->promocao.Produto',  $p->valorVenda->num < $p->valorReal->num && $p->valorVenda->num > 0);
					$iTP->enterRepeticao()->enterRepeticao()->trocar('valor.Produto',  "U$ ".$p->valorReal->moeda());
					$iTP->enterRepeticao()->enterRepeticao()->trocar('valorPromocional.Produto',  "U$ ".$p->valorVenda->moeda());
					$iTP->enterRepeticao()->enterRepeticao()->trocar('linkPedido.Produto',  Sistema::$caminhoURL.$_SESSION['lang']."/processar-carrinho&produto=".$p->getId());
					
					$parcelas = Pedido::__ParcelasPagSeguro($p->valor->num);
					foreach($parcelas as $k => $v){
						$iTP->enterRepeticao()->enterRepeticao()->condicao('condicao->Parcela'.$k.'.pagSeguro.valor.Produto',  $v > PagamentoPagSeguro::PARCELAMINIMA && $rsP['ativopagseguro']);
						$iTP->enterRepeticao()->enterRepeticao()->trocar('parcela'.$k.'.pagSeguro.valor.Produto',  Numero::__CreateNumero($v)->moeda());
					}
					
					if($linkPedido)
						$iTP->enterRepeticao()->enterRepeticao()->trocar('linkPedido.Produto',  Sistema::$caminhoURL.$_SESSION['lang']."/processar-carrinho&produto=".$p->getId());
					else
						$iTP->enterRepeticao()->enterRepeticao()->trocar('linkPedido.Produto',  $linkVisualizar);
					
					if($p->getImagens()->getTotal() > 0){
						$img = $p->getImagens()->listar("DESC", ListaImagens::DESTAQUE);
						if($img->getImage()->nome != ''){
							$iTP->enterRepeticao()->enterRepeticao()->trocar('imagem.Produto', $img->getImage()->showHTML(242, 200));
							$iTP->enterRepeticao()->enterRepeticao()->trocar('url.Imagem.Produto', $img->getImage()->pathImage(500, 500));
						}
					}
					
					$iTP->enterRepeticao()->enterRepeticao()->trocar('linkVisualizar.Produto', $linkVisualizar);
					
				}
				
				
				//Paginador
				$max = number_format($total/$por);
				if($max < $total/$por) $max++;
				if($max > $paginas){
					$paginas2 = (int) ($paginas/2);
					$inicioPaginas = (($_GET['pag'.$pC->getId()]+1)-$paginas2 < 1) ? 1 : (is_float($paginas/2) ? ($_GET['pag'.$pC->getId()]+1)-($paginas2) : ($_GET['pag'.$pC->getId()]+1)-($paginas2-1));
					$fimPaginas = ($inicioPaginas+$paginas-1 > $max) ? $max : $inicioPaginas+$paginas-1;
					$inicioPaginas += (($_GET['pag'.$pC->getId()]+1) > $fimPaginas-($paginas2) && is_float($paginas/2)) ? ($fimPaginas-$paginas2)-($_GET['pag'.$pC->getId()]+1) : 0;
				}else{
					$inicioPaginas = 1;
					$fimPaginas = $max;
				}
				$iTP->enterRepeticao()->condicao('condicao->Paginador.Produtos', $max > 1);
				$iTP->enterRepeticao()->createRepeticao('repetir->Paginador.Produtos');
				
				//Filtros
				$urlFiltros = '';
				if(count($arrayFiltros) > 0){
					$existefiltroarray = false;
					foreach($arrayFiltros as $k => $v)
						$urlFiltros .= '&filtro'.$k.'='.$v;
				}
				//
				
				for($i = $inicioPaginas; $i <= $fimPaginas; $i++){
					
					$iTP->enterRepeticao()->repetir();
					
					$iTP->enterRepeticao()->enterRepeticao()->condicao('condicao->Selecionada.Pagina.Produtos', $i-1 == $_GET['pag'.$pC->getId()]);
					$iTP->enterRepeticao()->enterRepeticao()->trocar('numero.Pagina.Produtos', $i);
					$iTP->enterRepeticao()->enterRepeticao()->trocar('linkVisualizar.Pagina.Produtos', Sistema::$caminhoURL.$_SESSION['lang']."/produtos".(!empty($procura) ? "/".$procura."/" : '/')."&pag".$pC->getId()."=".($i-1)."&busca=".$_GET['busca'].$urlFiltros);
					
				}
				
				$iTP->enterRepeticao()->condicao('condicao->Anterior.Paginador.Produtos', $_GET['pag'.$pC->getId()]+1 > 1);
				$iTP->enterRepeticao()->condicao('condicao->Proximo.Paginador.Produtos', $_GET['pag'.$pC->getId()]+1 < $max);
				$iTP->enterRepeticao()->trocar('linkVisualizar.Anterior.Paginador.Produtos', Sistema::$caminhoURL.$_SESSION['lang']."/produtos".(!empty($procura) ? "/".$procura."/" : '/')."&pag".$pC->getId()."=".($i-1)."&busca=".$_GET['busca']."&marca=".$_GET['marca'].$urlFiltros);
				$iTP->enterRepeticao()->trocar('linkVisualizar.Proximo.Paginador.Produtos', Sistema::$caminhoURL.$_SESSION['lang']."/produtos".(!empty($procura) ? "/".$procura."/" : '/')."&pag".$pC->getId()."=".($i-1)."&busca=".$_GET['busca']."&marca=".$_GET['marca'].$urlFiltros);
				
				//
				
			}
			
		}
	
	}else
		$iTP->condicao('condicao->ProdutoCategorias', false);
	
	if($pCP->getSubCategorias()->getTotal() == 0 || !empty($_GET['busca']) || $rsPR['listasubcategorias'] == 0){
				
		//$allCat = ProdutoCategoria::getIdAllSubCategoria($pCP->getId());
		$allCat = $pCP->getIdAllSubCategoria();
		$sql = '';
		/*for($i = 0; $i < count($allCat); $i++){
			$sql .= $allCat[$i];
			if($i < count($allCat)-1)
				$sql .= ', ';
		}*/
		foreach($allCat as $k => $v){
			$sql .= $k.",";
		}
		$sqlCat = substr($sql, 0, strlen($sql)-1);
		
		$sqlFiltros = '';
		foreach($arrayFiltros as $k => $v){
			$sqlFiltros .= "AND (SELECT COUNT(pog.id) FROM ".Sistema::$BDPrefixo."produtos_opcoes_gerados pog WHERE pog.opcao = '".$k."' AND pog.valor = '".$v."' AND pog.produto = p.id) > 0 ";
		}
		/*$sql = "SELECT a.id 
					FROM ((SELECT p.id 
							FROM ".Sistema::$BDPrefixo."produtos p 
							LEFT OUTER JOIN ".Sistema::$BDPrefixo."relacionamento_produtos_categorias rpc
								ON p.id = rpc.produto
							WHERE ".(!empty($sqlCat) ? "rpc.categoria IN 
									(".$sqlCat.")
								AND " : '')."p.".ListaProdutos::DISPONIVEL." = '".ListaProdutos::VALOR_DISPONIVEL_TRUE."' 
								".$sqlFiltros."
								AND p.produtopai = 0
								AND 
									(p.".ListaProdutos::CODIGO." = '".str_replace(" ", "%", $_GET['busca'])."' 
									OR p.".ListaProdutos::NOME." LIKE '%".str_replace(" ", "%", $_GET['busca'])."%' 
									OR p.".ListaProdutos::DESCRICAO." LIKE '%".str_replace(" ", "%", $_GET['busca'])."%') 
								".($pM->getId() != '' ? "AND 
									p.".ListaProdutos::MARCA." = ".$pM->getId() : '').")
					UNION
					(SELECT p.id
							FROM ".Sistema::$BDPrefixo."produtos p 
							INNER JOIN ".Sistema::$BDPrefixo."produtos p2
								ON p2.id = p.produtopai
							LEFT OUTER JOIN ".Sistema::$BDPrefixo."relacionamento_produtos_categorias rpc
								ON p.produtopai = rpc.produto
							WHERE ".(!empty($sqlCat) ? "rpc.categoria IN 
									(".$sqlCat.")
								AND " : '')."p2.".ListaProdutos::DISPONIVEL." = '".ListaProdutos::VALOR_DISPONIVEL_TRUE."' 
								".$sqlFiltros."
								AND p.produtopai > 0
								AND 
									(p.".ListaProdutos::CODIGO." = '".str_replace(" ", "%", $_GET['busca'])."'
									OR p2.".ListaProdutos::CODIGO." = '".str_replace(" ", "%", $_GET['busca'])."' 
									OR p.".ListaProdutos::NOME." LIKE '%".str_replace(" ", "%", $_GET['busca'])."%' 
									OR p2.".ListaProdutos::NOME." LIKE '%".str_replace(" ", "%", $_GET['busca'])."%' 
									OR p.".ListaProdutos::DESCRICAO." LIKE '%".str_replace(" ", "%", $_GET['busca'])."%'
									OR p2.".ListaProdutos::DESCRICAO." LIKE '%".str_replace(" ", "%", $_GET['busca'])."%')
								".($pM->getId() != '' ? "AND 
									p.".ListaProdutos::MARCA." = ".$pM->getId() : '')."
							GROUP BY p.produtopai)) a";	*/
		$sql = "SELECT a.id 
					FROM ((SELECT p.id 
							FROM ".Sistema::$BDPrefixo."produtos p 
							LEFT OUTER JOIN ".Sistema::$BDPrefixo."relacionamento_produtos_categorias rpc
								ON p.id = rpc.produto
							WHERE ".(!empty($sqlCat) ? "rpc.categoria IN 
									(".$sqlCat.")
								AND " : '')."p.".ListaProdutos::DISPONIVEL." = '".ListaProdutos::VALOR_DISPONIVEL_TRUE."' 
								".$sqlFiltros."
								AND p.produtopai = 0
								AND 
									(p.".ListaProdutos::CODIGO." = '".str_replace(" ", "%", $_GET['busca'])."' 
									OR p.".ListaProdutos::NOME." LIKE '%".str_replace(" ", "%", $_GET['busca'])."%' 
									OR p.".ListaProdutos::DESCRICAO." LIKE '%".str_replace(" ", "%", $_GET['busca'])."%') 
								".($pM->getId() != '' ? "AND 
									p.".ListaProdutos::MARCA." = ".$pM->getId() : '').")
					UNION
					(SELECT p.id
							FROM ".Sistema::$BDPrefixo."produtos p 
							INNER JOIN ".Sistema::$BDPrefixo."produtos p2
								ON p2.id = p.produtopai
							LEFT OUTER JOIN ".Sistema::$BDPrefixo."relacionamento_produtos_categorias rpc
								ON p.produtopai = rpc.produto
							WHERE ".(!empty($sqlCat) ? "rpc.categoria IN 
									(".$sqlCat.")
								AND " : '')."p2.".ListaProdutos::DISPONIVEL." = '".ListaProdutos::VALOR_DISPONIVEL_TRUE."' 
								".$sqlFiltros."
								AND p.produtopai > 0
								AND 
									(p.".ListaProdutos::CODIGO." = '".str_replace(" ", "%", $_GET['busca'])."'
									OR p2.".ListaProdutos::CODIGO." = '".str_replace(" ", "%", $_GET['busca'])."' 
									OR p.".ListaProdutos::NOME." LIKE '%".str_replace(" ", "%", $_GET['busca'])."%' 
									OR p2.".ListaProdutos::NOME." LIKE '%".str_replace(" ", "%", $_GET['busca'])."%' 
									OR p.".ListaProdutos::DESCRICAO." LIKE '%".str_replace(" ", "%", $_GET['busca'])."%'
									OR p2.".ListaProdutos::DESCRICAO." LIKE '%".str_replace(" ", "%", $_GET['busca'])."%')
								".($pM->getId() != '' ? "AND 
									p.".ListaProdutos::MARCA." = ".$pM->getId() : '')."
							)) a";
		
		
		
		 //$sql = "SELECT p.*, IF(p.nome='', (SELECT p2.nome FROM ".Sistema::$BDPrefixo."produtos p2 WHERE p2.id = p.produtopai), p.nome) as nome, IF(p.valorreal<=0, (SELECT p2.valorreal FROM ".Sistema::$BDPrefixo."produtos p2 WHERE p2.id = p.produtopai), p.valorreal) as valorreal FROM ".Sistema::$BDPrefixo."produtos p WHERE p.id IN (".$sql.") AND p.produtopai NOT IN (".$sql.")";				
		$sql = "SELECT p.*, IF(p.nome='', (SELECT p2.nome FROM ".Sistema::$BDPrefixo."produtos p2 WHERE p2.id = p.produtopai), p.nome) as nome, IF(p.valorreal<=0, (SELECT p2.valorreal FROM ".Sistema::$BDPrefixo."produtos p2 WHERE p2.id = p.produtopai), p.valorreal) as valorreal FROM ".Sistema::$BDPrefixo."produtos p WHERE p.id IN (".$sql.")";
		
		$lP = new ListaProdutos;
		$lP->condicoes('', '', '', '', $sql);
		//$lP->setGroup('p.id');
		$total = $lP->getTotal();
		
		if(empty($_GET['busca']))
			$iTP->trocar('navegador.ProdutoCategoria', !empty($nav) ? "<li><a href='".Sistema::$caminhoURL.$_SESSION['lang'].'/'.$pagina."'>".$idioma->getTraducaoByConteudo('Produtos')->traducao."</a>".'</li> '.$nav : "<li class='ativo'>".$idioma->getTraducaoByConteudo('Produtos')->traducao."</li>");
		else{
			$con = BDConexao::__Abrir();
			$tags = explode(" ", $_GET['busca']);
			foreach($tags as $k => $v){
				if(strlen($v) >= 3){
					$con->executar("SELECT * FROM ".Sistema::$BDPrefixo."produtos_termos_procurados WHERE termo = '".$v."'");
					if($con->getTotal() == 0){
						$con->executar("INSERT INTO ".Sistema::$BDPrefixo."produtos_termos_procurados(termo, contador) VALUES('".$v."', 1)");
					}else{
						$con->executar("UPDATE ".Sistema::$BDPrefixo."produtos_termos_procurados SET contador = contador+1 WHERE termo = '".$v."'");						
					}
				}
			}
			$iTP->trocar('navegador.ProdutoCategoria', $total > 0 ? "<li>".$idioma->getTraducaoByConteudo('busca realizada por')->traducao.' <i>"'.$_GET['busca'].'"</i></li>' : "<li>".$idioma->getTraducaoByConteudo('nenhum item encontrado por')->traducao.' "<i>'.$_GET['busca'].'</i></li>"');
		}

		if(!empty($pCP->nome))
			$iTP->trocar('traduzir->Produtos', $idioma->getTraducaoByConteudo($pCP->nome)->traducao);
			
		$iTP->condicao('condicao->Produtos', $total > 0);
		$iTP->createRepeticao('repetir->Produtos');
		
		if($total > 0){
			
			$con = BDConexao::__Abrir();
			$con->executar("SELECT * FROM ".Sistema::$BDPrefixo."pagamentos");
			$rsP = $con->getRegistro();
			
			$num = 0;
			$por = $rsPR['produtosporpagina'];
			$paginas = 10;
			$minimo = $_GET['pag']*$por;
			$maximo = $minimo+$por;
			
			$lP->setParametros($minimo)->setParametros($maximo, 'limite');
			$lP->enableDadosProdutoPai();

			
			if($_GET['order'] == 1 || empty($_GET['order'])){
				$order = ListaProdutos::NOME;
				$dir = "ASC";
				$_GET['order'] = 1;
			}elseif($_GET['order'] == 2){
				$order = ListaProdutos::NOME;
				$dir = "DESC";
			}elseif($_GET['order'] == 3){
				$order = ListaProdutos::VALORREAL;
				$dir = "ASC";
			}elseif($_GET['order'] == 4){
				$order = ListaProdutos::VALORREAL;
				$dir = "DESC";
			}

			//Filtros
			$urlFiltros = '';
			if(count($arrayFiltros) > 0){
				$existefiltroarray = false;
				foreach($arrayFiltros as $k => $v)
					$urlFiltros .= '&filtro'.$k.'='.$v;
			}
			//
			$iTP->trocar('order', $_GET['order']);
			$iTP->trocar('linkOrdenar', Sistema::$caminhoURL.$_SESSION['lang']."/produtos".(!empty($procura) ? "/".$procura."/" : '/')."&pag=".($_GET['pag'])."&busca=".$_GET['busca']."&marca=".$_GET['marca'].$urlFiltros."&");
            $i=0;
			while($p = $lP->listar($dir, $order)){

				$num++;
                $i++;
						
				$iTP->repetir();
				
				$cat = $p->getCategorias()->listar();


                $iTP->enterRepeticao()->condicao('condicao->BreakLine', $i>=3);
                if($i >= 3){
                    $i=0;
                }

				$iTP->enterRepeticao()->trocar('id.Produto', $p->getId());
				$iTP->enterRepeticao()->trocar('codigo.Produto', $p->codigo);
				$nome = $idioma->getTraducaoById(ListaProdutos::NOME, $lP->getTabela(), $p->getId())->traducao;
				$nome = !empty($nome) ? $nome : $idioma->getTraducaoById(ListaProdutos::NOME, $lP->getTabela(), $p->getProdutoPai())->traducao;
				$iTP->enterRepeticao()->trocar('nome.Produto', $nome);
				$iTP->enterRepeticao()->trocar('descricao.Produto',  $idioma->getTraducaoByConteudo($p->descricao)->traducao);
				$iTP->enterRepeticao()->trocar('descricaoPequena.Produto',  $idioma->getTraducaoByConteudo($p->descricaoPequena)->traducao);
				
				$iTP->enterRepeticao()->trocar('id.Marca.Produto', $p->getMarca()->getId());
				$iTP->enterRepeticao()->trocar('nome.Marca.Produto', $idioma->getTraducaoById(ListaProdutoMarcas::NOME, "produtos_marcas", $p->getMarca()->getId())->traducao);	
				if($p->getMarca()->getImagem()->nome != '')
					$iTP->enterRepeticao()->trocar('imagem.Marca.Produto', $p->getMarca()->getImagem()->showHTML(200, 15));
				$iTP->enterRepeticao()->trocar('linkVisualizar.Marca.Produto', Sistema::$caminhoURL.$_SESSION['lang']."/produtos/&marca=".$p->getMarca()->getURL()->url);			
				
				$linkPedido = true;
				while($pI = $p->getInfos()->listar()){
					$p->estoque += $pI->estoque;
					if($pI->estoque > 0)
						$linkPedido = false;
				}
				//($p->getMarca()->getId() == 182) || 
				$linkVisualizar = Sistema::$caminhoURL.$_SESSION['lang'].'/produtos/'.(!empty($procura) ? $procura : ($cat ? $cat->getURL()->getURL() : ''))."/".$p->getURL()->url;
				if($p->estoque <= 0 && $p->tipoPedido != Produto::TIPO_PEDIDO_SOB_CONSULTA && $rsP['tipopedidoprodutostodosite'] != Produto::TIPO_PEDIDO_SOB_CONSULTA && $rsP['tiposite'] == 2 && $rsP['tipopedido'] != 1){
					$iTP->enterRepeticao()->condicao('condicao->valor.Produto', false);
					$linkVisualizar .= '&pedido-estoque';
					$iTP->enterRepeticao()->trocar('acao.Produto', $idioma->getTraducaoByConteudo('Encomendar')->traducao);
				}elseif(($p->valorReal->num <= 0 || $p->tipoPedido == Produto::TIPO_PEDIDO_SOB_CONSULTA || $rsP['tipopedidoprodutostodosite'] == Produto::TIPO_PEDIDO_SOB_CONSULTA) || preg_match("!relojes!", $procura)){
					$iTP->enterRepeticao()->condicao('condicao->valor.Produto', false);
					$linkVisualizar .= '&consultar';
					$iTP->enterRepeticao()->trocar('acao.Produto', $idioma->getTraducaoByConteudo('Sob Consulta')->traducao);
				}else
					$iTP->enterRepeticao()->condicao('condicao->valor.Produto', true);
				
				$iTP->enterRepeticao()->condicao('condicao->promocao.Produto',  $p->valorVenda->num < $p->valorReal->num && $p->valorVenda->num > 0);
				$iTP->enterRepeticao()->trocar('valor.Produto',  "U$ ".$p->valorReal->moeda());
				$iTP->enterRepeticao()->trocar('valorPromocional.Produto',  "U$ ".$p->valorVenda->moeda());
				$iTP->enterRepeticao()->trocar('linkPedido.Produto',  Sistema::$caminhoURL.$_SESSION['lang']."/processar-carrinho&produto=".$p->getId());
				
				$parcelas = Pedido::__ParcelasPagSeguro($p->valor->num);
				foreach($parcelas as $k => $v){
					$iTP->enterRepeticao()->condicao('condicao->Parcela'.$k.'.pagSeguro.valor.Produto',  $v > PagamentoPagSeguro::PARCELAMINIMA && $rsP['ativopagseguro']);
					$iTP->enterRepeticao()->trocar('parcela'.$k.'.pagSeguro.valor.Produto',  Numero::__CreateNumero($v)->moeda());
				}
				
				if($linkPedido)
					$iTP->enterRepeticao()->trocar('linkPedido.Produto',  Sistema::$caminhoURL.$_SESSION['lang']."/processar-carrinho&produto=".$p->getId());
				else
					$iTP->enterRepeticao()->trocar('linkPedido.Produto',  $linkVisualizar);
				
				if($p->getImagens()->getTotal() > 0){
					$img = $p->getImagens()->listar("DESC", ListaImagens::DESTAQUE);
					if($img->getImage()->nome != ''){
						$iTP->enterRepeticao()->trocar('imagem.Produto', $img->getImage()->showHTML(242, 200));
						$iTP->enterRepeticao()->trocar('url.Imagem.Produto', $img->getImage()->pathImage(300, 300));
					}
				}else{
					$iTP->enterRepeticao()->trocar('imagem.Produto', '<img src="'.Sistema::$caminhoURL.'lib.img/sem-imagem.gif" height="200" />');
					$iTP->enterRepeticao()->trocar('url.Imagem.Produto', Sistema::$caminhoURL.'lib.img/sem-imagem.gif');
				}
				
				$iTP->enterRepeticao()->trocar('linkVisualizar.Produto', $linkVisualizar);
				
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
				$iTP->enterRepeticao()->createRepeticao("repetir->ProdutoOpcoes.Produto");
				$opcao = 0;
				while($rsPO = $con->getRegistro()){
					if($opcao != $rsPO['opcao']){
						$iTP->enterRepeticao()->repetir();
						$iTP->enterRepeticao()->enterRepeticao()->condicao("condicao->Texto.ProdutoOpcao.Produto", $rsPO['tipo'] == 0);
						$iTP->enterRepeticao()->enterRepeticao()->condicao("condicao->Cor.ProdutoOpcao.Produto", $rsPO['tipo'] == 2);
						$iTP->enterRepeticao()->enterRepeticao()->trocar("nome.ProdutoOpcao.Produto", $rsPO['nomeopcao']);
						$iTP->enterRepeticao()->enterRepeticao()->createRepeticao('repetir->ProdutoOpcaoValores.ProdutoOpcao.Produto');
						$opcao = $rsPO['opcao'];
					}
					$iTP->enterRepeticao()->enterRepeticao()->repetir();
					$iTP->enterRepeticao()->enterRepeticao()->enterRepeticao()->trocar("valor.ProdutoOpcaoValor.ProdutoOpcao.Produto", $rsPO['valor']);
					$iTP->enterRepeticao()->enterRepeticao()->enterRepeticao()->trocar("cor.ProdutoOpcaoValor.ProdutoOpcao.Produto", $rsPO['cor']);
					$iTP->enterRepeticao()->enterRepeticao()->enterRepeticao()->trocar("linkVisualizar.ProdutoOpcaoValor.ProdutoOpcao.Produto", Sistema::$caminhoURL.$_SESSION['lang'].'/produtos/'.(!empty($procura) ? $procura : ($cat ? $cat->getURL()->getURL() : ''))."/".(empty($rsPO['url']) ? $p->getURL()->url : $rsPO['url']));
				}
				
			}
			
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
			$iTP->condicao('condicao->Paginador.Topo.Produtos', $max > 1);
			$iTP->condicao('condicao->Paginador.Rodape.Produtos', $max > 1);
			$iTP->createRepeticao('repetir->Paginador.Topo.Produtos');
			$iTP->createRepeticao('repetir->Paginador.Rodape.Produtos');
			
			//Filtros
			$urlFiltros = '';
			if(count($arrayFiltros) > 0){
				$existefiltroarray = false;
				foreach($arrayFiltros as $k => $v)
					$urlFiltros .= '&filtro'.$k.'='.$v;
			}
			//
			
			for($i = $inicioPaginas; $i <= $fimPaginas; $i++){
				
				$iTP->repetir('repetir->Paginador.Topo.Produtos');
				$iTP->repetir('repetir->Paginador.Rodape.Produtos');
				
				$iTP->enterRepeticao('repetir->Paginador.Topo.Produtos')->condicao('condicao->Selecionada.Pagina.Produtos', $i-1 == $_GET['pag']);
				$iTP->enterRepeticao('repetir->Paginador.Topo.Produtos')->trocar('numero.Pagina.Produtos', $i);
				$iTP->enterRepeticao('repetir->Paginador.Topo.Produtos')->trocar('linkVisualizar.Pagina.Produtos', Sistema::$caminhoURL.$_SESSION['lang']."/produtos".(!empty($procura) ? "/".$procura."/" : '/')."&pag=".($i-1)."&busca=".$_GET['busca']."&marca=".$_GET['marca']."&order=".$_GET['order'].$urlFiltros);
				
				$iTP->enterRepeticao('repetir->Paginador.Rodape.Produtos')->condicao('condicao->Selecionada.Pagina.Produtos', $i-1 == $_GET['pag']);
				$iTP->enterRepeticao('repetir->Paginador.Rodape.Produtos')->trocar('numero.Pagina.Produtos', $i);
				$iTP->enterRepeticao('repetir->Paginador.Rodape.Produtos')->trocar('linkVisualizar.Pagina.Produtos', Sistema::$caminhoURL.$_SESSION['lang']."/produtos".(!empty($procura) ? "/".$procura."/" : '/')."&pag=".($i-1)."&busca=".$_GET['busca']."&marca=".$_GET['marca']."&order=".$_GET['order'].$urlFiltros);
				
			}

            $ant = ($_GET['pag']-1);
            $prox = ($_GET['pag']+1);

			$iTP->condicao('condicao->Anterior.Paginador.Topo.Produtos', $ant < 0);
			$iTP->condicao('condicao->Proximo.Paginador.Topo.Produtos', $_GET['pag']+1 < $max);
			$iTP->trocar('linkVisualizar.Anterior.Paginador.Topo.Produtos', Sistema::$caminhoURL.$_SESSION['lang']."/produtos".(!empty($procura) ? "/".$procura."/" : '/')."&pag=".($_GET['pag']-1)."&busca=".$_GET['busca']."&marca=".$_GET['marca']."&order=".$_GET['order'].$urlFiltros);
			$iTP->trocar('linkVisualizar.Proximo.Paginador.Topo.Produtos', Sistema::$caminhoURL.$_SESSION['lang']."/produtos".(!empty($procura) ? "/".$procura."/" : '/')."&pag=".($_GET['pag']+1)."&busca=".$_GET['busca']."&marca=".$_GET['marca']."&order=".$_GET['order'].$urlFiltros);
			
			$iTP->condicao('condicao->Anterior.Paginador.Rodape.Produtos', $_GET['pag']+1 > 1);
			$iTP->condicao('condicao->Proximo.Paginador.Rodape.Produtos', $prox >= $max);
			$iTP->trocar('linkVisualizar.Anterior.Paginador.Rodape.Produtos', Sistema::$caminhoURL.$_SESSION['lang']."/produtos".(!empty($procura) ? "/".$procura."/" : '/')."&pag=".($_GET['pag']-1)."&busca=".$_GET['busca']."&marca=".$_GET['marca']."&order=".$_GET['order'].$urlFiltros);
			$iTP->trocar('linkVisualizar.Proximo.Paginador.Rodape.Produtos', Sistema::$caminhoURL.$_SESSION['lang']."/produtos".(!empty($procura) ? "/".$procura."/" : '/')."&pag=".($_GET['pag']+1)."&busca=".$_GET['busca']."&marca=".$_GET['marca']."&order=".$_GET['order'].$urlFiltros);
			
			//
			
		}
	
	}else
		$iTP->condicao('condicao->Produtos', false);
	
	$lP->close();
	
	//include('lateral-direita.php');

	//$iTP->trocar('lateralDireita', $lateralDireita);

	
	$includePagina = $iTP->concluir();
	
}

?>