<?php

include('./lib.conf/includes.php');

importar("LojaVirtual.Pedidos.Lista.ListaPedidos");
importar("Geral.Idiomas.Lista.ListaIdiomas");

$lI  		= new ListaIdiomas;
if($lI->condicoes('', $_SESSION['lang'], ListaIdiomas::SIGLA)->getTotal() > 0)
	$idioma = $lI->listar();
else{
	$idioma = new Idioma;
	$idioma->sigla = 'br';
}
		
$lP = new ListaPedidos;
unset($condP);
if(!empty($_GET['pedido'])){
	$condP[1] = array('campo' => ListaPedidos::ID, 'valor' => $_GET['pedido']);
}else{
	$condP[1] = array('campo' => ListaPedidos::IDSESSAO, 'valor' => $_SESSION['usuario']['id']);
	$condP[2] = array('campo' => ListaPedidos::STATUS, 'valor' => PedidoStatus::CHECKOUT);
}

$lP->condicoes($condP);

if($lP->getTotal() > 0){

	$ped = $lP->listar();

	if($ped->getStatus()->getStatus() == PedidoStatus::ABERTO || $ped->getStatus()->getStatus() == PedidoStatus::CANCELADO)
		$ped->sendEmail('Pedido realizado pelo site', null, true);

	$status = PedidoStatus::AGUARDANDO_CONTATO;
	$ped->setStatus($status);
	
	$ped->estoque = 1;
	
	$lPR = new ListaProdutos;
	
	while($pI = $ped->getItem()->listar()){
		
		$lPR->condicoes('', $pI->getId(), ListaProdutos::ID);
		if($lPR->getTotal() > 0){
			$pR = $lPR->listar();
			$pR->estoque = $pR->estoque-$pI->quantidade;	
			$lPR->alterar($pR);
		}
		
	}
	
	$ped->sendEmail('Status de Pedido alterado', $idioma);
	
	$lP->alterar($ped);	
	
	header("Location: ".Sistema::$caminhoURL.$_SESSION['lang']."/pedido&pedido=".$ped->getId());	
	
}else
	header("Location: ".Sistema::$caminhoURL.$_SESSION['lang']);	
    
?>