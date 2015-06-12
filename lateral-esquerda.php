<?php

importar("LojaVirtual.Categorias.Lista.ListaProdutoCategorias");
importar("LojaVirtual.Produtos.Opcoes.Lista.ListaProdutoOpcaoValores");
importar("Utilidades.Publicidades.Mailing.Lista.ListaPacoteMailings");

$iLE = new InterFaces(new Arquivos(Sistema::$layoutCaminhoDiretorio."lateral-esquerda.html"));

$iLE->trocar('lang', $_SESSION['lang']);
$iLE->setSession($_SESSION);
$iLE->condicao("condicao->Usuario", !empty($_SESSION['usuario']));

/*if(!empty($_POST['email-news'])){
	
	$lPM = new ListaPacoteMailings;
	$lPM->condicoes('', 1, ListaPacoteMailings::ID);
	if($lPM->getTotal() > 0){
		
		$pM = $lPM->listar();
		try{
			$pM->addEmail($_POST['email-news']);
			$javaScript .= Aviso::criar($idioma->getTraducaoByConteudo("E-mail cadastrado com sucesso")->traducao."!");
		}catch(Exception $e){
			$javaScript .= Aviso::criar($idioma->getTraducaoByConteudo($e->getMessage())->traducao."!");	
		}
	}
	
}*/

/*$lBC = new ListaBannerCategorias;
$lBC->condicoes('', 2, ListaBannerCategorias::ID);
if($lBC->getTotal() > 0){
		
	$bC = $lBC->listar();
	
	$total = 0;
	$iLE->createRepeticao("repetir->Banners");
	while($b = $bC->getBanners()->listar('ASC', ListaBanners::DATAINICIO)){
		
		if($b->ativo){
			$iLE->repetir();
			$total++;
			$iLE->enterRepeticao()->trocar('url.Imagem.Banner', $b->getImagem()->pathImage(200, 3000));
			$iLE->enterRepeticao()->trocar('imagem.Banner', $b->getImagem()->showHTML(200, 3000));
			$iLE->enterRepeticao()->trocar('enderecoURL.Banner', $b->enderecoURL);
			$iLE->enterRepeticao()->trocar('legenda.Banner', $b->legenda);
			$iLE->enterRepeticao()->trocar('posicao.Banners', $total);

		}
	
	}
	
	$iLE->condicao('condicao->Banners', $total > 0);
	
}else
	$iLE->condicao('condicao->Banners', false);*/


//Categorias
$lPO = new ListaProdutoOpcoes;
$lPOV = new ListaProdutoOpcaoValores;
$lPOG = new ListaProdutoOpcaoGerados;
$lP = new ListaProdutos;

$lPM = new ListaProdutoMarcas;
if(!empty($_GET['marca'])){
	
	$lU = new ListaURLs;
	
	$cond[1] = array('campo' => ListaURLs::URL, 	'valor' => $_GET['marca']);
	$cond[2] = array('campo' => ListaURLs::TABELA, 	'valor' => $lPM->getTabela());
	
	if($lU->condicoes($cond)->getTotal() > 0){
		$lPM->condicoes('', $lU->listar()->valor, ListaProdutoMarcas::ID);	
	}

}
if($lPM->getTotal() > 0)
	$pM 	= $lPM->listar();
else
	$pM 	= new ProdutoMarca;
	
$lPC = new ListaProdutoCategorias;
$lPC->condicoes();
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

if($lPC->getTotal() > 0){
	
	$pCA 	= $lPC->listar();
	$allCat = $pCA->getIdAllSubCategoria();
	$sqlCat = '';
	for($i = 0; $i < count($allCat); $i++){
		$sqlCat .= $allCat[$i];
		if($i < count($allCat)-1)
			$sqlCat .= ', ';
	}
	$sqlFiltros = "SELECT pov.*, 
						(SELECT po.nome 
							FROM ".Sistema::$BDPrefixo.$lPO->getTabela()." po 
							WHERE po.id = pov.opcao) as nomeopcao 
						FROM ".Sistema::$BDPrefixo.$lPOV->getTabela()." pov 
						WHERE pov.id IN 
							(SELECT pog.valor 
								FROM ".Sistema::$BDPrefixo.$lPOG->getTabela()." pog 
								WHERE pog.produto IN 
									(SELECT j.id FROM ((SELECT rpc.produto as id
										FROM ".Sistema::$BDPrefixo."relacionamento_produtos_categorias rpc
										WHERE rpc.categoria IN 
											(".$sqlCat.")
									)
									UNION
									(SELECT p.id as id
										FROM ".Sistema::$BDPrefixo.$lP->getTabela()." p 
										WHERE p.produtopai IN 
											(SELECT rpc2.produto
												FROM ".Sistema::$BDPrefixo."relacionamento_produtos_categorias rpc2
												WHERE rpc2.categoria IN
													(".$sqlCat.")
											)
									)) j)
							)
							AND 
							(SELECT po.filtro 
								FROM ".Sistema::$BDPrefixo.$lPO->getTabela()." po 
								WHERE po.id = pov.opcao) = '".ListaProdutoOpcoes::VALOR_FILTRO_TRUE."' 
						ORDER BY nomeopcao, pov.valor ASC";
}else{
	$pCA 	= new ProdutoCategoria;
	$sqlFiltros = "SELECT pov.*, po.nome as nomeopcao
						FROM ".Sistema::$BDPrefixo.$lPOV->getTabela()." pov
						INNER JOIN ".Sistema::$BDPrefixo.$lPO->getTabela()." po
							ON po.id = pov.opcao
						WHERE po.filtro = '".ListaProdutoOpcoes::VALOR_FILTRO_TRUE."'
						ORDER BY nomeopcao, pov.valor ASC";
}


$lPC->condicoes('', $pCA->getIdCategoriaPai(), ListaProdutoCategorias::ID);
if($lPC->getTotal() > 0){
	$pCP = $lPC->listar();
	$idPai = $pCP->getId();
	$visaoUnicaPai = $pCP->visaoUnica;
}else{
	$pCP = new ProdutoCategoria;
	$idPai = $pCP->getId();
	$visaoUnicaPai = $pCP->visaoUnica;
}

if($pCA->getSubCategorias()->getTotal() == 0){
	$lPC->condicoes('', $pCP->getIdCategoriaPai(), ListaProdutoCategorias::ID);
	if($lPC->getTotal() > 0)
		$pCP = $lPC->listar();
	else
		$pCP = new ProdutoCategoria;
}

$iLE->condicao('condicao->ProdutoCategoriaPai', $pCP->getId() != '');
$iLE->trocar('linkVisualizar.ProdutoCategoriaPai', Sistema::$caminhoURL.$_SESSION['lang']."/produtos/".$pCP->getURL()->url);

$aPC[1] = array('campo' => ListaProdutoCategorias::DISPONIVEL, 'valor' => ListaProdutoCategorias::VALOR_DISPONIVEL_TRUE);

if($pCA->visaoUnica)
	$aPC[2] = array('campo' => ListaProdutoCategorias::ID, 'valor' => $pCA->getId());
elseif($visaoUnicaPai)
	$aPC[2] = array('campo' => ListaProdutoCategorias::ID, 'valor' => $idPai);

$pCP->getSubCategorias()->condicoes($aPC);
$iLE->createRepeticao('repetir->ProdutoCategorias');
while($pC = $pCP->getSubCategorias()->listar("ASC", ListaProdutoCategorias::ORDEM)){
	
	$filtros = false;
	
	$iLE->repetir();
	
	$iLE->enterRepeticao()->trocar('id.ProdutoCategoria', $pC->getId());
	$iLE->enterRepeticao()->trocar('nome.ProdutoCategoria', $idioma->getTraducaoById(ListaProdutoCategorias::NOME, $lPC->getTabela(), $pC->getId())->traducao);
	$iLE->enterRepeticao()->trocar('url.Imagem.ProdutoCategoria', $pC->getImagem()->pathImage(282, 118));
	$iLE->enterRepeticao()->trocar('linkVisualizar.ProdutoCategoria', Sistema::$caminhoURL.$_SESSION['lang']."/produtos/".$pC->getURL()->url);
	$aPSC[1] = array('campo' => ListaProdutoCategorias::DISPONIVEL, 'valor' => ListaProdutoCategorias::VALOR_DISPONIVEL_TRUE);
	$pC->getSubCategorias()->condicoes($aPSC);
	$iLE->enterRepeticao()->condicao('condicao->SubCategorias.ProdutoCategoria', $pC->getSubCategorias()->getTotal() > 0);
	$iLE->enterRepeticao()->condicao('condicao->Pointer', $pagina === 'produtos' && !empty($procura));
	$iLE->enterRepeticao()->createRepeticao("repetir->ProdutoCategorias.ProdutoCategoria");
	if($pC->getSubCategorias()->getTotal() > 0){
		
		while($c = $pC->getSubCategorias()->listar("ASC", ListaProdutoCategorias::ORDEM)){
			
			$iLE->enterRepeticao()->repetir();
			
			$iLE->enterRepeticao()->enterRepeticao()->trocar("id.ProdutoCategoria.ProdutoCategoria", $c->getId());
			$iLE->enterRepeticao()->enterRepeticao()->trocar("nome.ProdutoCategoria.ProdutoCategoria", $idioma->getTraducaoById(ListaProdutoCategorias::NOME, $lPC->getTabela(), $c->getId())->traducao);
			$iLE->enterRepeticao()->enterRepeticao()->trocar("linkVisualizar.ProdutoCategoria.ProdutoCategoria", Sistema::$caminhoURL.$_SESSION['lang']."/produtos/".$c->getURL()->url);
			
			if($c->getId() == $pCA->getId())
				$filtros = true;
				
			$c->getSubCategorias()->condicoes($aPSC);
			$iLE->enterRepeticao()->enterRepeticao()->condicao('condicao->SubCategorias.ProdutoCategoria.ProdutoCategoria', $c->getSubCategorias()->getTotal() > 0);
			$iLE->enterRepeticao()->enterRepeticao()->createRepeticao("repetir->ProdutoCategorias.ProdutoCategoria.ProdutoCategoria");
			//echo $pC->nome." - ".$c->nome.": ".$c->getSubCategorias()->getTotal()."
//";
			if($c->getSubCategorias()->getTotal() > 0){
				
				while($c2 = $c->getSubCategorias()->listar("ASC", ListaProdutoCategorias::ORDEM)){
					
					$iLE->enterRepeticao()->enterRepeticao()->repetir();
					
					$iLE->enterRepeticao()->enterRepeticao()->enterRepeticao()->trocar("id.ProdutoCategoria.ProdutoCategoria.ProdutoCategoria", $c2->getId());
					$iLE->enterRepeticao()->enterRepeticao()->enterRepeticao()->trocar("nome.ProdutoCategoria.ProdutoCategoria.ProdutoCategoria", $idioma->getTraducaoById(ListaProdutoCategorias::NOME, $lPC->getTabela(), $c2->getId())->traducao);
					$iLE->enterRepeticao()->enterRepeticao()->enterRepeticao()->trocar("linkVisualizar.ProdutoCategoria.ProdutoCategoria.ProdutoCategoria", Sistema::$caminhoURL.$_SESSION['lang']."/produtos/".$c2->getURL()->url);
					
					if($c2->getId() == $pCA->getId())
						$filtros = true;
					
				}
				
			}
			
		}
		
	}
	
	if($pC->getId() == $pCA->getId() || ($pCA->getId() == '' && $pCP->getSubCategorias()->getParametros() == $pCP->getSubCategorias()->getTotal()))
		$filtros = true;
	
	$iLE->enterRepeticao()->createRepeticao("repetir->ProdutoOpcoes");
	if($filtros && !empty($sqlFiltros) && $pagina == 'produtos' && empty($procura2) && false){
		
		$con = BDConexao::__Abrir();
		$con->executar($sqlFiltros);
		$opcao = 0;
		while($rs = $con->getRegistro()){
			
			if($opcao != $rs['opcao']){
				$iLE->enterRepeticao()->repetir();
				$iLE->enterRepeticao()->enterRepeticao()->trocar("id.ProdutoOpcao", $rs['opcao']);
				$iLE->enterRepeticao()->enterRepeticao()->trocar("nome.ProdutoOpcao", $rs['nomeopcao']);
				$iLE->enterRepeticao()->enterRepeticao()->createRepeticao('repetir->ProdutoOpcaoValores.ProdutoOpcao');
				$opcao = $rs['opcao'];
			}
			
			
			$iLE->enterRepeticao()->enterRepeticao()->repetir();
			
			$iLE->enterRepeticao()->enterRepeticao()->enterRepeticao()->trocar('valor.ProdutoOpcaoValor.ProdutoOpcao', $rs['valor']);
			
			if(count($arrayFiltros) > 0){
				$urlFiltros = '';
				$existefiltroarray = false;
				foreach($arrayFiltros as $k => $v){
					if($k == $rs['opcao']){
						$urlFiltros .= '&filtro'.$k.'='.$rs['id'];
						$existefiltroarray = true;
					}else
						$urlFiltros .= '&filtro'.$k.'='.$v;
				}
				if(!$existefiltroarray)
					$urlFiltros .= '&filtro'.$rs['opcao'].'='.$rs['id'];
			}else
				$urlFiltros = '&filtro'.$rs['opcao'].'='.$rs['id'];
				
			$iLE->enterRepeticao()->enterRepeticao()->enterRepeticao()->trocar('linkVisualizar.ProdutoOpcaoValor.ProdutoOpcao', $url.$urlFiltros);
			
		} 
		
		$allCat = $pCA->getIdAllSubCategoria();
		$sqlCat = '';
		for($i = 0; $i < count($allCat); $i++){
			$sqlCat .= $allCat[$i];
			if($i < count($allCat)-1)
				$sqlCat .= ', ';
		}
		$lPM = new ListaProdutoMarcas;
		$con = BDConexao::__Abrir();
		while($pMN = $lPM->listar("ASC", ListaProdutoMarcas::NOME)){
			
			$con->executar("SELECT COUNT(rpc.produto) as total
								FROM ".Sistema::$BDPrefixo."relacionamento_produtos_categorias rpc
								INNER JOIN ".Sistema::$BDPrefixo."produtos p 
									ON p.id = rpc.produto
								WHERE rpc.categoria IN
										(".$sqlCat.")
								AND p.marca = '".$pMN->getId()."'");
			$rs = $con->getRegistro();
			
			if($rs['total'] > 0){
				
				$urlFiltros = '';
				
				if($opcao != 'Marcas'){
					$iLE->enterRepeticao()->repetir();
					$iLE->enterRepeticao()->enterRepeticao()->trocar("id.ProdutoOpcao", 'marcas');
					$iLE->enterRepeticao()->enterRepeticao()->trocar("nome.ProdutoOpcao", 'Marcas');
					$iLE->enterRepeticao()->enterRepeticao()->createRepeticao('repetir->ProdutoOpcaoValores.ProdutoOpcao');
					$opcao = 'Marcas';
				}
				
				if($iLE->enterRepeticao()->enterRepeticao()){
				
					$iLE->enterRepeticao()->enterRepeticao()->repetir();
					
					$iLE->enterRepeticao()->enterRepeticao()->enterRepeticao()->trocar('valor.ProdutoOpcaoValor.ProdutoOpcao', $pMN->nome);
					
					if(count($arrayFiltros) > 0){
						$existefiltroarray = false;
						foreach($arrayFiltros as $k => $v)
							$urlFiltros .= '&filtro'.$k.'='.$v;
					}
					
					$urlFiltros .= '&marca='.$pMN->getURL()->url;
						
					$iLE->enterRepeticao()->enterRepeticao()->enterRepeticao()->trocar('linkVisualizar.ProdutoOpcaoValor.ProdutoOpcao', $url.$urlFiltros);
				
				}
			
			}
			
		}
			
	}
	
}

//

$javaScript .= $iLE->createJavaScript()->concluir();

$lateralEsquerda = $iLE->concluir();

?>