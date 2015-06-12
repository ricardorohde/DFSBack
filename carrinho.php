<?php

$_SESSION['url'] = Sistema::$caminhoURL.$_SESSION['lang']."/carrinho";

if(empty($_SESSION['usuario']))
	header('Location: '.Sistema::$caminhoURL.$_SESSION['lang']."/login");


importar("LojaVirtual.Pedidos.Lista.ListaPedidos");
importar("TemTudoAqui.Usuarios.Lista.ListaPessoas");
importar("Utils.EnvioEmail");
importar("JavaScript.Alertas.Aviso");

$con = BDConexao::__Abrir();
$con->executar("SELECT * FROM ".Sistema::$BDPrefixo."pagamentos");
$rsP = $con->getRegistro();

$con->executar("SELECT * FROM ".Sistema::$BDPrefixo."frete");
$rsF = $con->getRegistro();

$iTT = new InterFaces(new Arquivos(Sistema::$layoutCaminhoDiretorio."carrinho.html"));
$iTT->setSession($_SESSION);
$iTT->trocar('lang', $_SESSION['lang']);

//include('lateral-esquerda.php');
//$iTT->trocar('lateralEsquerda', $lateralEsquerda);

$lP = new ListaPessoas;
$lP->condicoes('', $_SESSION['usuario']['id'], ListaPessoas::ID);

if($lP->getTotal() > 0)
	$p = $lP->listar();
else{
	header('Location: '.Sistema::$caminhoURL.$_SESSION['lang']."/login");
	exit;
}

$endP = $p->getEndereco()->listar();
$telP = $p->getTelefone()->listar();

$lP = new ListaProdutos;

$lPE = new ListaPedidos;
$condP[1] = array('campo' => ListaPedidos::IDSESSAO, 'valor' => $p->getId());
$condP[2] = array('campo' => ListaPedidos::STATUS, 'valor' => PedidoStatus::ABERTO);
$lPE->condicoes($condP);

$iTT->createRepeticao("repetir->PedidoItens");

$con->executar("SELECT * FROM ".Sistema::$BDPrefixo."frete");
$rs = $con->getRegistro();

if($lPE->getTotal() > 0){

	$ped = $lPE->listar();
	$valorCep = 0;
	
	$iTT->condicao('condicao->CarrinhoVazio', $ped->getItem()->getTotal() == 0);
	
	if(!empty($_POST)){

		$qtdT = 0;
		
		if(count($_POST['quantidade']) > 0){

			foreach($_POST['quantidade'] as $prd => $qtd){
				
				$lPE->setParametros(0);
				$ped = $lPE->listar();
				
				$cond[1] = array('campo' => ListaPedidoItens::ID, 		'valor' => $prd);
				$ped->getItem()->condicoes($cond);
				
				$pI = $ped->getItem()->listar();
								
				$lP->condicoes('', $pI->getId(), ListaProdutos::ID);
				$pR = $lP->listar();
				
				$estoque = $pI->estoque;	
				
				if($qtd <= $estoque || $rsP['tipopedido'] == 1){

					$pI->quantidade = $qtd;

					$ped->addItem($pI);

				}
				
				$qtdT += $pI->quantidade;
				
			}
			
			if($_POST['cepDestino'] != $ped->getEndereco()->getCep()){
				$ped->setEndereco(new PedidoEnderecoEntrega($ped->getEndereco()->getId()));
				$ped->getEndereco()->setCep($_POST['cepDestino']);
			}
			
			if($ped->getEndereco()->getCep() == $endP->getCep())
				$ped->setEndereco(PedidoEnderecoEntrega::__EnderecoToPedidoEnderecoEntrega($endP));
			elseif($ped->getEndereco()->getCep() != ''){
				$ped->getEndereco()->loadCep();
			}
			
			$ped->getEndereco()->tipo = $_POST['cep'];
			
			if(!empty($_POST['cupom'])){
				$ped->cupom = $_POST['cupom'];
			}
			

		}

		try{
			$ped->calcular();
			$ped->calcularFrete();
			
			$pDesconto = 0;
			if($ped->cupom == $rsP['codigodesconto'])
				$pDesconto = $rsP['porcentagemdesconto'];
			
			if($p->atacadista && $qtdT >= 15){
				$pDesconto += 50;
			}
			
			if($pDesconto > 0){
				$desconto = (float)(((float) $ped->getValor()->num*$pDesconto)/100);
				$ped->setDesconto($desconto);	
			}
			
			$lPE->alterar($ped);
		}catch(Exception $e){
			$javaScript .= Aviso::criar($idioma->getTraducaoByConteudo($e->getMessage())->traducao);
		}			
		
		$lPE->setParametros(0);
		$ped = $lPE->listar();
		
		if(isset($_GET['finalizar']))
			header('Location: '.Sistema::$caminhoURL.$_SESSION['lang']."/finalizar-pedido");	
		
		if(isset($_GET['enviar']))
			header('Location: '.Sistema::$caminhoURL.$_SESSION['lang']."/enviar-pedido");		

	}

	if(!empty($ped)){

		$total = 0;
		$end = $ped->getEndereco();
		
		$sobconsulta = false;
		
		$iTT->condicao("condicao->tipo.Endereco.Pedido", !empty($end->tipo));
		$iTT->trocar($end->tipo.'.Endereco.Pedido', "checked=\"checked\"");
		$iTT->trocar('cep.Endereco.Pedido', $end->getCep());			
		//echo $ped->hasFrete();
		while($pI = $ped->getItem()->listar()){
			
			if($pI){
				
				$cat = $pI->getCategorias()->listar();
				
				$lP->condicoes('', $pI->getProdutoPai(), ListaProdutos::ID);
				if($lP->getTotal() > 0){
					$produtoPai = $lP->listar();
					$cat = $produtoPai->getCategorias()->listar();
				}				
				
				$iTT->repetir();
				$iTT->enterRepeticao()->trocar("n.PedidoItem", $ped->getItem()->getParametros());
				$iTT->enterRepeticao()->trocar("id.PedidoItem", $pI->getId());
				$iTT->enterRepeticao()->trocar("quantidade.PedidoItem", $pI->quantidade);
				$iTT->enterRepeticao()->trocar("nome.PedidoItem", $idioma->getTraducaoByConteudo($pI->nome)->traducao.($pI->observacao != '' ? ' '.$pI->observacao : ''));
				
				if($pI->tipoPedido == Produto::TIPO_PEDIDO_SOB_CONSULTA)
					$sobconsulta = true;
				$iTT->enterRepeticao()->condicao("condicao->PedidoOrcamento.PedidoItem", $pI->tipoPedido == Produto::TIPO_PEDIDO_SOB_CONSULTA || $rsP['tipopedidoprodutostodosite'] == Produto::TIPO_PEDIDO_SOB_CONSULTA);
				$iTT->enterRepeticao()->trocar("valor.PedidoItem", "$ ".$pI->valor->moeda());	
				$iTT->enterRepeticao()->trocar("valorFrete.PedidoItem", $pI->getValorFrete()->formatar());
				
				$iTT->enterRepeticao()->createRepeticao('repetir->ProdutoOpcoes.PedidoItem');
				while($pOG = $pI->getOpcoes()->listar('ASC', ListaProdutoOpcaoGerados::OPCAO)){			
					$iTT->enterRepeticao()->repetir();
					$iTT->enterRepeticao()->enterRepeticao()->trocar("id.ProdutoOpcao.PedidoItem", $pOG->getOpcao()->getId());			
					$iTT->enterRepeticao()->enterRepeticao()->trocar("nome.ProdutoOpcao.PedidoItem", $idioma->getTraducaoByConteudo($pOG->getOpcao()->nome)->traducao);			
					$iTT->enterRepeticao()->enterRepeticao()->trocar("id.ProdutoOpcaoValor.PedidoItem", $pOG->getValor()->getId());			
					$iTT->enterRepeticao()->enterRepeticao()->trocar("valor.ProdutoOpcaoValor.PedidoItem", $idioma->getTraducaoByConteudo($pOG->getValor()->valor)->traducao);		
					$iTT->enterRepeticao()->enterRepeticao()->trocar("cor.ProdutoOpcaoValor.PedidoItem", $pOG->getValor()->cor);	
				}
				
				$iTT->enterRepeticao()->trocar('estoque.PedidoItem',  $rsP['tipopedido'] == 1 ? 9999999999 : $pI->estoque);
				$estoque = $pI->estoque;				
				$valorP = $pI->valor;
				
				$iTT->enterRepeticao()->trocar("valorPonto.PedidoItem", (string) Numero::__CreateNumero(($valorP->formatar()))->formatar());
	
				$total += ($pI->valor->num*$pI->quantidade);
				
				
				if($pI->getImagens()->getTotal() > 0){
					$img = $pI->getImagens()->listar("DESC", ListaImagens::DESTAQUE);
					$iTT->enterRepeticao()->trocar("url.Imagem.PedidoItem", $img->getImage()->pathImage(60, 100));
					$iTT->enterRepeticao()->trocar("imagem.PedidoItem", $img->getImage()->showHTML(60, 100));
				}
	
				$iTT->enterRepeticao()->trocar("linkDeletar.PedidoItem", Sistema::$caminhoURL.$_SESSION['lang']."/processar-carrinho&produto=".$pI->getId()."&deletar");
				
				$lPT = new ListaProdutos;
				$lPT->condicoes('', $pI->getId(), ListaProdutos::ID);
				if($lPT->getTotal() > 0)
					$iTT->enterRepeticao()->trocar("linkVisualizar.PedidoItem", Sistema::$caminhoURL.$_SESSION['lang']."/produtos/".$cat->getURL()->url."/".($produtoPai ? $produtoPai->getURL()->url : $pI->getURL()->url));

			}

		}

		$iTT->trocar("tipo.Endereco.Pedido", !empty($end->tipo) ? $end->tipo : '');
		
		$iTT->condicao('condicao->ExisteFrete', $ped->hasFrete() && $ped->getItem()->getTotal() > 0);
		$iTT->condicao('condicao->ExistePrazo', $end->prazo > 0 && $ped->getItem()->getTotal() > 0);
		$iTT->condicao('condicao->ExisteFreteCorreios', $rs['ativocorreio']);		
		$iTT->trocar("valor.Endereco.Pedido", $ped->freeFrete() && $ped->getEndereco()->getCep() != '' ? $idioma->getTraducaoByConteudo('Grátis')->traducao : ($end->getValor()->num > 0 ? "$ ".$end->getValor()->moeda() : ''));
		$iTT->trocar("tipo.Endereco.Pedido", PedidoEnderecoEntrega::GetNameType($end->tipo));
		$iTT->trocar("prazo.Endereco.Pedido", $end->prazo);
		
		//$ped->getDesconto()->num > 0 || $rsP['ativodesconto']
		$iTT->condicao('condicao->Desconto', $rsP['ativodesconto']);
		$iTT->trocar('desconto', "$ ".$ped->getDesconto()->moeda());
		$total -= $ped->getDesconto()->num;
		
		$iTT->condicao("condicao->SobConsulta", $rsP['tipopedidoprodutostodosite'] == Produto::TIPO_PEDIDO_SOB_CONSULTA || $sobconsulta);
		$iTT->trocar("total", "$ ".Numero::__CreateNumero($total+$end->getValor()->num)->moeda());
		
		$iTT->condicao("condicao->PedidoOrcamento", $rsP['tipopedidoprodutostodosite'] == Produto::TIPO_PEDIDO_SOB_CONSULTA);
		
		$iTT->condicao("condicao->PedidoSemVenda", $rsP['tipopedido'] == 1 || $sobconsulta);
		
	}

}else	
	$iTT->condicao('condicao->CarrinhoVazio', true);

$javaScript .= $iTT->createJavaScript()->concluir();
$includePagina = $iTT->concluir();

?>