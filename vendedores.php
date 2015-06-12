<?php

importar("Utilidades.Lista.ListaVendedores");

$iTV = new InterFaces(new Arquivos(Sistema::$layoutCaminhoDiretorio."vendedores.html"));

$lV = new ListaVendedores;

$iTV->createRepeticao('repetirVendedores');
while($vd = $lV->listar("ASC", ListaVendedores::NOME)){
	
	$iTV->repetir();
	$iTV->enterRepeticao()->trocar('nomeVendedor', $vd->nome);
	$iTV->enterRepeticao()->trocar('emailVendedor', $vd->email);
	$iTV->enterRepeticao()->trocar('voipVendedor', $vd->voip);
	$iTV->enterRepeticao()->trocar('telefoneVendedor', $vd->telefone);
	$iTV->enterRepeticao()->trocar('skypeVendedor', $vd->skype);
	$iTV->enterRepeticao()->trocar('ramalVendedor', $vd->ramal);
	$iTV->enterRepeticao()->trocar('msn', $vd->msn);
	
	if(!empty($vd->getImagem()->getImage()->nome)){
		$iTV->enterRepeticao()->trocar('imagemVendedor', $vd->getImagem()->getImage()->showHTML(170, 170));
	}else{
		$iTV->enterRepeticao()->trocar('imagemVendedor','<img src="'.Sistema::$layoutCaminhoURL	.'lib.img/sem-imagem.gif" width="170" />');
	}
		

}

$includePagina = $iTV->concluir();

?>