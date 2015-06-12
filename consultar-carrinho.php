<?php

include('./lib.conf/includes.php');

importar("Geral.Idiomas.Lista.ListaIdiomas");
importar("LojaVirtual.Pedidos.Lista.ListaPedidos");
importar("TemTudoAqui.Usuarios.Lista.ListaPessoas");

//Idiomas
$lI  		= new ListaIdiomas;
if($lI->condicoes('', $_SESSION['lang'], ListaIdiomas::SIGLA)->getTotal() > 0)
	$idioma = $lI->listar();
else{
	$idioma = new Idioma;
	$idioma->sigla = 'br';
}
//

if(empty($_SESSION['usuario']))
	echo "{msg: '".$idioma->getTraducaoByConteudo('Não há nenhum item')->traducao."'}";
else{
	
	$lP = new ListaPessoas;
	$lP->condicoes('', $_SESSION['usuario']['id'], ListaPessoas::ID);
	
	if($lP->getTotal() > 0){
		
		$p = $lP->listar();
		$lPE = new ListaPedidos;
		$condP[1] = array('campo' => ListaPedidos::IDSESSAO, 'valor' => $p->getId());
		$condP[2] = array('campo' => ListaPedidos::STATUS, 'valor' => PedidoStatus::ABERTO);
		$lPE->condicoes($condP);
		if($lPE->getTotal() > 0){
			$ped = $lPE->listar();
			if($ped->getItem()->getTotal() == 0)
				$msg = $idioma->getTraducaoByConteudo('Não há nenhum item')->traducao;
			else{
				$msg = $idioma->getTraducaoByConteudo('Há')->traducao.' '.$ped->getItem()->getTotal().' item(s)';
			}
		}else
			$msg = $idioma->getTraducaoByConteudo('Não há nenhum item')->traducao;
		
	}else
		$msg = $idioma->getTraducaoByConteudo('Não há nenhum item')->traducao;
		
	echo "{msg: '".$msg."'}";
		
}
	