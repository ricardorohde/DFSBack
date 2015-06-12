<?php

$_SESSION['url'] = Sistema::$caminhoURL.$_SESSION['lang']."/carrinho";

if(empty($_SESSION['usuario']))
	header('Location: '.Sistema::$caminhoURL.$_SESSION['lang']."/login");

importar("LojaVirtual.Pedidos.Lista.ListaPedidos");
importar("LojaVirtual.Pedidos.Pagamentos.PagamentoPagSeguro");
importar("LojaVirtual.Pedidos.Pagamentos.PagamentoDeposito");
importar("TemTudoAqui.Usuarios.Lista.ListaPessoas");
importar("Utils.EnvioEmail");
importar("JavaScript.Alertas.Aviso");

$lPE = new ListaPedidos;
$aRP[1] = array('campo' => ListaPedidos::ID, 	'valor' => $_GET['pedido']);
$lPE->condicoes($aRP);

if($lPE->getTotal() > 0){
	
	$ped = $lPE->listaR();
	
	$iTT = new InterFaces(new Arquivos(Sistema::$layoutCaminhoDiretorio."pedido.html"));

	$iTT->setSession($_SESSION);
	$iTT->trocar('lang', $_SESSION['lang']);

	//include('lateral-esquerda.php');
	//$iTT->trocar('lateralEsquerda', $lateralEsquerda);
	
	$p = $ped->getCliente();
	
	$endP = $p->getEndereco()->listar();
	$telP = $p->getTelefone()->listar();
	
	$lP = new ListaProdutos;
	
	$iTT->createRepeticao("repetir->PedidoItens");
	
	$con->executar("SELECT * FROM ".Sistema::$BDPrefixo."frete");
	$rs = $con->getRegistro();
	$con->executar("SELECT * FROM ".Sistema::$BDPrefixo."pagamentos");
	$rsP = $con->getRegistro();
		
	$total = 0;
	$end = $ped->getEndereco();		
	
	$iTT->condicao("condicao->Alterar.Endereco.Pedido", isset($_GET['alterar-endereco']) || $end->getCep() == '' || $end->logradouro == '' || $end->numero == '' || $end->bairro == '' || $end->getCidade()->nome == '' || $end->getEstado()->uf == '');
	$iTT->condicao("condicao->tipo.Endereco.Pedido", !empty($end->tipo));
	$iTT->trocar($end->tipo.'.Endereco.Pedido', "checked=\"checked\"");
	$iTT->trocar('cep.Endereco.Pedido', $end->getCep());
	$iTT->trocar('logradouro.Endereco.Pedido', $end->logradouro);
	$iTT->trocar('ddd.Telefone.Pedido', $tel->ddd);
	$iTT->trocar('telefone.Telefone.Pedido', $tel->telefone);
	$iTT->trocar('numero.Endereco.Pedido', $end->numero);
	$iTT->trocar('complemento.Endereco.Pedido', $end->complemento);
	$iTT->trocar('bairro.Endereco.Pedido', $end->bairro);
	$iTT->trocar('cidade.Endereco.Pedido', $end->getCidade()->nome);
	$iTT->trocar('estado.Endereco.Pedido', $end->getEstado()->uf);
	
	$iTT->trocar("tipoPagamento.Pedido", $ped->getTipoPagamento());
	$iTT->trocar("status.Pedido", $idioma->getTraducaoByConteudo($ped->getStatus())->traducao);
	
	$recuperar = true;
	
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
						
			$valorP = $pI->valor;
			
			$iTT->enterRepeticao()->trocar("valorPonto.PedidoItem", (string) Numero::__CreateNumero(($valorP->formatar()))->formatar());

			$total += ($pI->valor->num*$pI->quantidade);
				
			if($pI->getImagens()->getTotal() > 0){
				$img = $pI->getImagens()->listar("DESC", ListaImagens::DESTAQUE);
				$iTT->enterRepeticao()->trocar("url.Imagem.PedidoItem", $img->getImage()->pathImage(60, 100));
				$iTT->enterRepeticao()->trocar("imagem.PedidoItem", $img->getImage()->showHTML(60, 100));
			}
			
			if($pI->quantidade > $pI->estoque)
				$recuperar = false;
		}

	}
	
	
	$iTT->condicao('condicao->Desconto', $ped->getDesconto()->num > 0);
	$iTT->trocar('desconto', "R$ ".$ped->getDesconto()->moeda());
	$total -= $ped->getDesconto()->num;
	
	$iTT->condicao("condicao->RecuperarPedido", $ped->getStatus()->getStatus() == PedidoStatus::CANCELADO && $recuperar);
	$iTT->trocar("linkFinalizar.Pedido", Sistema::$caminhoURL.$_SESSION['lang']."/finalizar-pedido&pedido=".$ped->getId()."&recuperar");
	
	$iTT->condicao("condicao->DepositoPagamento", $ped->getTipoPagamento() == (string) new PagamentoDeposito);
	$iTT->trocar("textoDeposito", nl2br($rsP['textodeposito']));
			
	$iTT->condicao('condicao->ExisteFrete', $ped->hasFrete() && $ped->getItem()->getTotal() > 0);
	$iTT->condicao('condicao->ExistePrazo', $ped->getEndereco()->prazo > 0 && $ped->getItem()->getTotal() > 0);
	$iTT->condicao('condicao->ExisteFreteCorreios', $rs['ativocorreio']);		
	$iTT->trocar("valor.Endereco.Cliente", $ped->freeFrete() ? $idioma->getTraducaoByConteudo('Grátis')->traducao : ($end->getValor()->num > 0 ? "R$ ".$end->getValor()->moeda() : ''));
	$iTT->trocar("tipo.Endereco.Pedido", PedidoEnderecoEntrega::GetNameType($end->tipo));
	$iTT->trocar("prazo.Endereco.Pedido", $ped->getEndereco()->prazo);
	$iTT->trocar("total", "R$ ".Numero::__CreateNumero($total+$end->getValor()->num)->moeda());
	
	$iTT->trocar("observacoes", $ped->observacoes);
	
	$javaScript .= $iTT->createJavaScript()->concluir();
	$includePagina = $iTT->concluir();
	
}

?>