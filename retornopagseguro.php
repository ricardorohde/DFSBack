<?php

include('./lib.conf/includes.php');

importar("LojaVirtual.Pedidos.Lista.ListaPedidos");
importar("LojaVirtual.PagSeguroLibrary.PagSeguroLibrary");
importar("Geral.Idiomas.Lista.ListaIdiomas");

$lI  		= new ListaIdiomas;
if($lI->condicoes('', $_SESSION['lang'], ListaIdiomas::SIGLA)->getTotal() > 0)
	$idioma = $lI->listar();
else{
	$idioma = new Idioma;
	$idioma->sigla = 'br';
}

function write($v, $a = 'eta'){
	
	$f = fopen('lib.data/'.$a.'.txt', 'w+');
	fwrite($f, $v);
	fclose($f);
	
}

$code = $_POST['notificationCode'];
$type = $_POST['notificationType'];

/*ob_start();
echo var_dump($_POST);
$ver = ob_get_contents();
ob_clean();
write($code." - ".$type.": ".$ver, 'ver');*/
if ( $code && $type ) {
	
	$notificationType = new PagSeguroNotificationType($type);
	$strType = $notificationType->getTypeFromValue();
	
	switch($strType) {
		
		case 'TRANSACTION':
			
			$con = BDConexao::__Abrir();
			$con->executar("SELECT * FROM ".Sistema::$BDPrefixo."pagamentos");
			$rsP = $con->getRegistro();
			
			$con->executar("SELECT * FROM ".Sistema::$BDPrefixo."frete");
			$rsF = $con->getRegistro();
			
			$credentials = new PagSeguroAccountCredentials($rsP['emailpagseguro'], $rsP['tokenpagseguro']);
			
			try {
				
				$transaction = PagSeguroNotificationService::checkTransaction($credentials, $code);
				
				$lP = new ListaPedidos;
				$lP->condicoes('', $transaction->getReference(), ListaPedidos::ID);
				
				if($lP->getTotal() > 0){
				
					$ped = $lP->listar();
				
					if($ped->getStatus()->getStatus() == PedidoStatus::ABERTO || $ped->getStatus()->getStatus() == PedidoStatus::CANCELADO)
						$ped->sendEmail('Pedido realizado pelo site', null, true);
				
					if($transaction->getStatus()->getValue() == 3)
						$status = PedidoStatus::ENTREGA;
					elseif($transaction->getStatus()->getValue() == 1)
						$status = PedidoStatus::COBRANCA;
					elseif($transaction->getStatus()->getValue() == 6)
						$status = PedidoStatus::CANCELADO;
					elseif($transaction->getStatus()->getValue() == 2)
						$status = PedidoStatus::ESPERA;
					
					$ped->setStatus($status);
					
					if($status == PedidoStatus::ESPERA){
						
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
						
					}
				
					if($status == PedidoStatus::ENTREGA && $ped->estoque == 0){
						
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
						
					}
					
					if($ped->estoque == 1 && $status == PedidoStatus::CANCELADO){
						
						$ped->estoque = 0;
						
						$lPR = new ListaProdutos;
						
						while($pI = $ped->getItem()->listar()){
							
							$lPR->condicoes('', $pI->getId(), ListaProdutos::ID);
							if($lPR->getTotal() > 0){
								$pR = $lPR->listar();
								$pR->estoque = $pR->estoque+$pI->quantidade;
								$lPR->alterar($pR);
							}
							
						}
						
					}
									
					if($rsP['fretepagseguro']){
						$ped->getEndereco()->tipo = $transaction->getShipping()->getType()->getValue() == 1 ? PedidoEnderecoEntrega::FRETE_TIPO_PAC : PedidoEnderecoEntrega::FRETE_TIPO_SEDEX;
						$ped->getEndereco()->setValor($transaction->getShipping()->getCost());
					}
							
					$lP->alterar($ped);
					
					$ped->sendEmail($idioma->getTraducaoByConteudo('Status de Pedido alterado')->traducao, $idioma);
					
				}else
					write('Referencia de pedido inválido!');
				
			} catch (PagSeguroServiceException $e) {
				write($e->getMessage());
			}
			break;
		
		default:
			write("Unknown notification type [".$notificationType->getValue()."]");
			
	}
	
} else {
	
	write("Invalid notification parameters.");
	
}    
    
?>