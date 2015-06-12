<?php

$_SESSION['url'] = Sistema::$caminhoURL.$_SESSION['lang']."/carrinho";

if(empty($_SESSION['usuario']))
	header('Location: '.Sistema::$caminhoURL.$_SESSION['lang']."/login");

importar("LojaVirtual.Pedidos.Lista.ListaPedidos");
importar("LojaVirtual.Pedidos.Pagamentos.PagamentoPagSeguro");
importar("TemTudoAqui.Usuarios.Lista.ListaPessoas");
importar("Utils.EnvioEmail");
importar("JavaScript.Alertas.Aviso");


$lPE = new ListaPedidos;
$aRP[1] = array('campo' => ListaPedidos::ID, 	'valor' => $_GET['pedido']);
$lPE->condicoes($aRP);

if($lPE->getTotal() > 0){
	
	$ped = $lPE->listaR();
	
	
	//if($lP->getTotal() > 0){
		$iTT = new InterFaces(new Arquivos(Sistema::$layoutCaminhoDiretorio."pedido-reprovado.html"));
	//}else($lP->getTotal() > 0){
		//$iTT = new InterFaces(new Arquivos(Sistema::$layoutCaminhoDiretorio."pedido-aprovado.html"));
	//}
	$iTT->setSession($_SESSION);
	$iTT->trocar('lang', $_SESSION['lang']);
	
	$p = $ped->getCliente();
	
	$endP = $p->getEndereco()->listar();
	$telP = $p->getTelefone()->listar();
	
	$lP = new ListaProdutos;
	
	$iTT->createRepeticao("repetir->PedidoItens");
	
	$con->executar("SELECT * FROM ".Sistema::$BDPrefixo."frete");
	$rs = $con->getRegistro();
		
	$total = 0;
	$end = $ped->getEndereco();		
	
	try{
		$ped->calcularFrete();
		$lPE->alterar($ped);
	}catch(Exception $e){
		$javaScript .= Aviso::criar($idioma->getTraducaoByConteudo($e->getMessage())->traducao);
	}
	if(isset($_POST['notificationCode']) && trim($_POST['notificationCode']) !== ""){
	$f = fopen('lib.data/eta.txt', 'w+');
	fwrite($f, $_POST['notificationCode']);
	fclose($f);
	}
	
	$iTT->condicao("condicao->Alterar.Endereco.Pedido", isset($_GET['alterar-endereco']) || $end->getCep() == '' || $end->logradouro == '' || $end->numero == '' || $end->bairro == '' || $end->cidade == '' || $end->estado == '');
	$iTT->condicao("condicao->tipo.Endereco.Pedido", !empty($end->tipo));
	$iTT->trocar($end->tipo.'.Endereco.Pedido', "checked=\"checked\"");
	$iTT->trocar('cep.Endereco.Pedido', $end->getCep());
	$iTT->trocar('logradouro.Endereco.Pedido', $end->logradouro);
	$iTT->trocar('ddd.Telefone.Pedido', $tel->ddd);
	$iTT->trocar('telefone.Telefone.Pedido', $tel->telefone);
	$iTT->trocar('numero.Endereco.Pedido', $end->numero);
	$iTT->trocar('complemento.Endereco.Pedido', $end->complemento);
	$iTT->trocar('bairro.Endereco.Pedido', $end->bairro);
	$iTT->trocar('cidade.Endereco.Pedido', $end->cidade);
	$iTT->trocar('estado.Endereco.Pedido', $end->estado);
	
	$iTT->trocar("tipoPagamento.Pedido", $ped->getTipoPagamento());
	$iTT->trocar("status.Pedido", $idioma->getTraducaoByConteudo($ped->getStatus())->traducao);
	
	while($pI = $ped->getItem()->listar()){
		
		if($pI){
			
			$lP->condicoes('', $pI->getProdutoPai(), ListaProdutos::ID);
			if($lP->getTotal() > 0)
				$produtoPai = $lP->listar();
			
			$cat = $produtoPai ? $produtoPai->getCategorias()->listar() : $pI->getCategorias()->listar();
			
			$iTT->repetir();
			$iTT->enterRepeticao()->trocar("n.PedidoItem", $ped->getItem()->getParametros());
			$iTT->enterRepeticao()->trocar("id.PedidoItem", $pI->getId());
			$iTT->enterRepeticao()->trocar("quantidade.PedidoItem", $pI->quantidade);
			$iTT->enterRepeticao()->trocar("nome.PedidoItem", $idioma->getTraducaoByConteudo($pI->nome)->traducao.($pI->observacao != '' ? ' '.$pI->observacao : ''));
			
			$iTT->enterRepeticao()->trocar("valor.PedidoItem", "R$ ".$pI->valor->moeda());
			
			$iTT->enterRepeticao()->condicao('condicao->ProdutoCor.PedidoItem', $pI->getCor()->getId());			
			$iTT->enterRepeticao()->trocar("id.ProdutoCor.PedidoItem", $pI->getCor()->getId());			
			$iTT->enterRepeticao()->trocar("nome.ProdutoCor.PedidoItem", $idioma->getTraducaoByConteudo($pI->getCor()->nome)->traducao);		
			$iTT->enterRepeticao()->trocar("hexadecimal.ProdutoCor.PedidoItem", $pI->getCor()->hexadecimal);
			
			$iTT->enterRepeticao()->condicao('condicao->ProdutoTamanho.PedidoItem', $pI->getTamanho()->getId());			
			$iTT->enterRepeticao()->trocar("id.ProdutoTamanho.PedidoItem", $pI->getTamanho()->getId());			
			$iTT->enterRepeticao()->trocar("nome.ProdutoTamanho.PedidoItem", $idioma->getTraducaoByConteudo($pI->getTamanho()->nome)->traducao);	
			
			$iTT->enterRepeticao()->condicao('condicao->ProdutoPedra.PedidoItem', $pI->getPedra()->getId());			
			$iTT->enterRepeticao()->trocar("id.ProdutoPedra.PedidoItem", $pI->getPedra()->getId());			
			$iTT->enterRepeticao()->trocar("nome.ProdutoPedra.PedidoItem", $idioma->getTraducaoByConteudo($pI->getPedra()->nome)->traducao);		
			
			
			$valorP = $pI->valor;
			
			$iTT->enterRepeticao()->trocar("valorPonto.PedidoItem", (string) Numero::__CreateNumero(($valorP->formatar()))->formatar());

			$total += ($pI->valor->num*$pI->quantidade);
				
			if($pI->getImagens()->getTotal() > 0)
				$iTT->enterRepeticao()->trocar("imagem.PedidoItem", $pI->getImagens()->listar("DESC", ListaImagens::DESTAQUE)->getImage()->showHTML(60, 1000));

		}

	}
			
	$iTT->condicao('condicao->ExisteFrete', $ped->hasFrete() && $ped->getItem()->getTotal() > 0);
	$iTT->condicao('condicao->ExistePrazo', $ped->getEndereco()->prazo > 0 && $ped->getItem()->getTotal() > 0);
	$iTT->condicao('condicao->ExisteFreteCorreios', $rs['ativocorreio']);		
	$iTT->trocar("valor.Endereco.Cliente", $ped->freeFrete() ? $idioma->getTraducaoByConteudo('Grátis')->traducao : ($end->getValor()->num > 0 ? "R$ ".$end->getValor()->moeda() : ''));
	$iTT->trocar("prazo.Endereco.Pedido", $ped->getEndereco()->prazo);
	$iTT->trocar("total", "R$ ".Numero::__CreateNumero($total+$end->getValor()->num)->moeda());
	
	$iTT->trocar("observacoes", $ped->observacoes);
	
	$javaScript .= $iTT->createJavaScript()->concluir();
	$includePagina = $iTT->concluir();
	
}

?>