<?php

$_SESSION['url'] = Sistema::$caminhoURL.$_SESSION['lang']."/historico-pedido";

if(empty($_SESSION['usuario']))
	header('Location: '.Sistema::$caminhoURL.$_SESSION['lang']."/login");

importar("LojaVirtual.Pedidos.Lista.ListaPedidos");

$iTT = new InterFaces(new Arquivos(Sistema::$layoutCaminhoDiretorio."historico-pedido.html"));
$iTT->setSession($_SESSION);

//include('lateral-esquerda.php');
//$iTT->trocar('lateralEsquerda', $lateralEsquerda);

$lP = new ListaPessoas;
$lP->condicoes('', $_SESSION['usuario']['id'], ListaPessoas::ID);
if($lP->getTotal() > 0)
	$p = $lP->listar();
else
	header('Location: '.Sistema::$caminhoURL.$_SESSION['lang']."/login");

$lPE = new ListaPedidos;
unset($condP);
$condP[1] = array('campo' => ListaPedidos::IDSESSAO, 'valor' => $p->getId());
$lPE->condicoes($condP);

$iTT->createRepeticao("repetir->Pedidos");

if($lPE->getTotal() > 0){

	
	while($ped = $lPE->listar("DESC")){
		
		$iTT->repetir();
		
		$iTT->enterRepeticao()->trocar("id.Pedido", $ped->getId());
		$iTT->enterRepeticao()->trocar("data.Pedido", $ped->getData()->mostrar());
		$iTT->enterRepeticao()->trocar("valor.Pedido", "R$ ".Numero::__CreateNumero($ped->getValor()->formatar()+$ped->getEndereco()->getValor()->formatar())->moeda());
		$iTT->enterRepeticao()->trocar("status.Pedido", $idioma->getTraducaoByConteudo($ped->getStatus())->traducao);
		$iTT->enterRepeticao()->trocar("linkVisualizar.Pedido", Sistema::$caminhoURL.$_SESSION['lang']."/pedido&pedido=".$ped->getId());
				
	}
	
}

$javaScript .= $iTT->createJavaScript()->concluir();
$includePagina = $iTT->concluir();

?>