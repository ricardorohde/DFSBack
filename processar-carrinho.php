<?php

importar("LojaVirtual.Produtos.Lista.ListaProdutos");
importar("LojaVirtual.Produtos.Lista.ListaProdutoCores");
importar("LojaVirtual.Produtos.Lista.ListaProdutoTamanhos");
importar("LojaVirtual.Produtos.Lista.ListaProdutoPedras");
importar("LojaVirtual.Pedidos.Lista.ListaPedidos");

$_SESSION['url'] = Sistema::$caminhoURL.$_SESSION['lang']."/processar-carrinho";

if(empty($_SESSION['usuario'])){
	$_SESSION['produto'] = $_POST;
	header("Location: ".Sistema::$caminhoURL.$_SESSION['lang']."/login");
	exit;
}elseif(empty($_POST)){
	$_POST = $_SESSION['produto'];
}

$lPE = new ListaPedidos;
$condP[1] = array('campo' => ListaPedidos::IDSESSAO, 'valor' => $_SESSION['usuario']['id']);
$condP[2] = array('campo' => ListaPedidos::STATUS, 'valor' => PedidoStatus::ABERTO);
$lPE->condicoes($condP);

$con = BDConexao::__Abrir();
$con->executar("SELECT * FROM ".Sistema::$BDPrefixo."pagamentos");
$rsP = $con->getRegistro();

if($lPE->getTotal() > 0)
	$ped = $lPE->listar();
else{
	$ped = new Pedido;
	
	$lPS = new ListaPessoas;
	$lPS->condicoes("", $_SESSION['usuario']['id'], ListaPessoas::ID);
	if($lPS->getTotal() > 0){
		$ped->setCliente($lPS->listar());
		$lPE->inserir($ped);
	}else
		header("Location: ".Sistema::$caminhoURL.$_SESSION['lang']."/carrinho");
}

if(count($_POST['idproduto']) > 0){

	foreach($_POST['idproduto'] as $k => $v){
		
		if($v > 0){
		
			$lP = new ListaProdutos;
			$lP->condicoes("", $v, ListaProdutos::ID);
			if($lP->getTotal() > 0){
				
				$p = $lP->listar();
					
				$cond[1] = array('campo' => ListaPedidoItens::ID, 		'valor' => $p->getId());
				$ped->getItem()->condicoes($cond);
				
				if($ped->getItem()->getTotal() > 0){
					
					$pI = $ped->getItem()->listar();
					if(empty($_POST['quantidade'][$k]))
						$qtd = $pI->quantidade+1;
					else{
						
						$estoque = $pI->estoque;
						
						if(($pI->quantidade+$_POST['quantidade'][$k]) > $estoque && $rsP['tipopedido'] != 1)
							$qtd = $estoque;
						else
							$qtd = $pI->quantidade+$_POST['quantidade'][$k];
						
					}
					
					$pI->quantidade = $qtd;
					$ped->getItem()->alterar($pI, $ped);
					
				}elseif(($rsP['tiposite'] == 2 && $p->estoque > 0 && $p->valor->num > 0) || ($rsP['tiposite'] == 2 && ($rsP['tipopedido'] == 1 && $p->valor->num > 0) || $rsP['tipopedidoprodutosdosite'] == 1 || $p->tipoPedido)){
					
					$pI = PedidoItem::__ProdutoToPedidoItem($p);
					
					while($pOG = $pI->getOpcoes()->listar('ASC', ListaProdutoOpcaoGerados::OPCAO))
						$pI->nome .= ' '.$pOG->getValor()->valor;
					
					if(empty($_POST['quantidade'][$k]))
						$qtd = 1;
					else{
						
						$estoque = $pI->estoque;
						
						if($_POST['quantidade'][$k] > $estoque && $rsP['tipopedido'] != 1)
							$qtd = $estoque;
						else
							$qtd = $_POST['quantidade'][$k];
						
					}
					
					$pI->quantidade = $qtd;
					$ped->addItem($pI);
				
				}
				
			}
		
		}
	
	}

}

if(!empty($_GET['produto'])){
		
	$cond[1] = array('campo' => ListaPedidoItens::ID, 		'valor' => $_GET['produto']);
	$ped->getItem()->condicoes($cond);
	
	if(isset($_GET['deletar'])){
		
		$pI = $ped->getItem()->listar();
		if($pI)
			$ped->removeItem($pI);
		
	}
	
}

if($ped->getEndereco()->getCep() && $ped->getEndereco()->tipo){
				
	try{
		$ped->calcularFrete();
	}catch(Exception $e){
		
	}
	
}

$ped->calcular();
$ped->getItem()->resetCondicoes();
$cond[1] = array('campo' => ListaPedidoItens::IDSESSAO, 'valor' => $ped->getId());
$ped->getItem()->condicoes($cond);
$qtdT = 0;
while($pI = $ped->getItem()->listar())
	$qtdT += $pI->quantidade;
	
if($ped->getCliente()->atacadista && $qtdT >= 15){
	$desconto = (float)((float) $ped->getValor()->num/2);
	$ped->setDesconto($desconto);
}else
	$ped->setDesconto(0);
	
$lPE->alterar($ped);

unset($_SESSION['produto']);
header("Location: ".Sistema::$caminhoURL.$_SESSION['lang']."/carrinho");
exit;

?>