<?php

$_SESSION['url'] = Sistema::$caminhoURL.$_SESSION['lang']."/finalizar-pedido&pedido=".$_GET['pedido'].(isset($_GET['recuperar']) ? "&recuperar" : '');

if(empty($_SESSION['usuario']))
	header('Location: '.Sistema::$caminhoURL.$_SESSION['lang']."/login");

importar("LojaVirtual.Pedidos.Lista.ListaPedidos");
importar("LojaVirtual.Pedidos.Pagamentos.PagamentoPagSeguro");
importar("LojaVirtual.Pedidos.Pagamentos.PagamentoDeposito");
importar("TemTudoAqui.Usuarios.Lista.ListaPessoas");
importar("Utils.EnvioEmail");
importar("JavaScript.Alertas.Aviso");
importar("Geral.Lista.ListaUsuarios");

$iTT = new InterFaces(new Arquivos(Sistema::$layoutCaminhoDiretorio."finalizar-pedido.html"));
$iTT->setSession($_SESSION);
$iTT->trocar('lang', $_SESSION['lang']);

//include('lateral-esquerda.php');
//$iTT->trocar('lateralEsquerda', $lateralEsquerda);

$lP = new ListaPessoas;
$lP->condicoes('', $_SESSION['usuario']['id'], ListaPessoas::ID);

if($lP->getTotal() > 0)
	$p = $lP->listar();
else
	header('Location: '.Sistema::$caminhoURL.$_SESSION['lang']."/login");

$endP = $p->getEndereco()->listar();
$telP = $p->getTelefone()->listar();

$lP = new ListaProdutos;

$lPE = new ListaPedidos;
unset($condP);
if(!empty($_GET['pedido'])){
	$condP[1] = array('campo' => ListaPedidos::ID, 'valor' => $_GET['pedido']);
	//$condP[2] = array('campo' => ListaPedidos::STATUS, 'valor' => PedidoStatus::CANCELADO);
}else{
	$condP[1] = array('campo' => ListaPedidos::IDSESSAO, 'valor' => $p->getId());
	$condP[2] = array('campo' => ListaPedidos::STATUS, 'valor' => PedidoStatus::ABERTO);
}

$lPE->condicoes($condP);

$iTT->createRepeticao("repetir->PedidoItens");

$con->executar("SELECT * FROM ".Sistema::$BDPrefixo."frete");
$rs = $con->getRegistro();

if($lPE->getTotal() > 0){

	$ped = $lPE->listar();
	$valorCep = 0;
	$finalizar = true;
	
	if(!empty($ped)){
		
		$total = 0;
		
		$iTT->trocar('cep.Endereco.Cliente', $endP->getCep());
		$iTT->trocar('logradouro.Endereco.Cliente', $endP->logradouro);
		$iTT->trocar('ddd.Telefone.Cliente', $tel->ddd);
		$iTT->trocar('telefone.Telefone.Cliente', $tel->telefone);
		$iTT->trocar('numero.Endereco.Cliente', $endP->numero);
		$iTT->trocar('complemento.Endereco.Cliente', $endP->complemento);
		$iTT->trocar('bairro.Endereco.Cliente', $endP->bairro);
		$iTT->trocar('cidade.Endereco.Cliente', $endP->getCidade()->nome);
		$iTT->trocar('estado.Endereco.Cliente', $endP->getEstado()->uf);
		
		$end = $ped->getEndereco();
		
		if($ped->getEndereco()->getId() == '' || $end->getCep() == ''){
			
			$endE = PedidoEnderecoEntrega::__EnderecoToPedidoEnderecoEntrega($endP);
			$endE->tipo = $end->tipo;
			$end = $endE;
			$ped->setEndereco($end);
			
		}
		
		if(!empty($_POST)){
			
			if(!empty($_POST['pagamento'])){
				
				$erro = false;
					
				if($end->getCep() == '' || $end->logradouro == '' || $end->numero == '' || $end->numero == '0' || $end->bairro == '' || $end->getCidade()->nome == '' || $end->getEstado()->uf == ''){
					$iTT->traocar('erroEndereco', $idioma->getTraducaoByConteudo("Endereço de entrega incompleto")->traducao."!");
					$erro = true;
				}
				
				if(!$erro){
					
					try{						
						
						$ped->observacoes = $_POST['observacoes'];
						
						//Vendedor
						$lU = new ListaUsuarios;
						$lU->condicoes("", $_SESSION['lang'], ListaUsuarios::LOGIN);
						if($lU->getTotal() > 0)
							$u = $lU->listar();
						else
							$u = new Usuario;
							
						$ped->setVendedor($u->getId());
						//
						
						if($_POST['pagamento'] == 'pagseguro'){
							
							$pay = new PagamentoPagSeguro;
							$pay->urlRetorno = Sistema::$caminhoURL.$_SESSION['lang']."/pedido&pedido=".$ped->getId();
							$url = $ped->checkout($pay);
							$ped->setStatus(PedidoStatus::CHECKOUT);
							$lPE->alterar($ped);
							if(!isset($_GET['recuperar']))
								$ped->sendEmail('Pedido gerado com sucesso', $idioma);
							header("Location: ".$url);
							exit;							
						}elseif($_POST['pagamento'] == 'deposito'){
							$pay = new PagamentoDeposito;
							$url = $ped->checkout($pay);
							$ped->setStatus(PedidoStatus::CHECKOUT);
							$lPE->alterar($ped);
							if(!isset($_GET['recuperar']))
								$ped->sendEmail('Pedido gerado com sucesso', $idioma);
							header("Location: ".$url);
							exit;							
						}
					
					}catch(Exception $e){
						$iTT->trocar('erroPagamento', (trim(nl2br(str_replace("\r", "", str_replace("\n", "", str_replace('"', "'", $idioma->getTraducaoByConteudo($e->getMessage())->traducao)))))));
					}
				
				}
				
			}
			
			if(!empty($_POST['cep'])){
			
				$end->setCep($_POST['cep']);
				
				$lE = new ListaEstados;
				$lE->condicoes('', strtoupper($_POST['estado']), ListaEstados::UF);
				if($lE->getTotal() > 0)
					$end->setEstado($lE->listar());
				else{
					$end->getEstado()->uf = strtoupper($_POST['estado']);
					$end->getEstado()->setPais(new Pais(1));					
				}
				
				$lC = new ListaCidades;
				$lC->condicoes('', $_POST['cidade'], ListaCidades::NOME);
				if($lC->getTotal() > 0)
					$end->setCidade($lC->listar());
				else{
					$end->getCidade()->nome = $_POST['cidade'];
					$end->getCidade()->setEstado($end->getEstado());
				}
				
				$end->logradouro = $_POST['logradouro'];
				$end->numero = $_POST['numero'];
				$end->complemento = $_POST['complemento'];
				$end->bairro = $_POST['bairro'];
				$end->loadCep();
				
				$ped->setEndereco($end);
			
			}
			
		}
		
		if(isset($_GET['endereco-cobranca'])){
			
			$endE = PedidoEnderecoEntrega::__EnderecoToPedidoEnderecoEntrega($endP);
			$endE->tipo = $end->tipo;
			$end = $endE;
			$ped->setEndereco($end);
			
		}
		
		try{
			$ped->calcularFrete();
			$lPE->alterar($ped);
		}catch(Exception $e){
			$iTT->trocar('erroPedido', ($idioma->getTraducaoByConteudo($e->getMessage())->traducao));
		}
		
		$iTT->condicao("condicao->Alterar.Endereco.Pedido", (isset($_GET['alterar-endereco']) || $end->getCep() == '' || $end->logradouro == '' || $end->numero == '' || $end->numero == '0' || $end->bairro == '' || $end->getCidade()->nome == '' || $end->getEstado()->uf == ''));
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

			}

		}
		
		$iTT->condicao('condicao->Desconto', $ped->getDesconto()->num > 0);
		$iTT->trocar('desconto', "R$ ".$ped->getDesconto()->moeda());
		$total -= $ped->getDesconto()->num;
		
		$iTT->condicao('condicao->ExisteFrete', $ped->hasFrete() && $ped->getItem()->getTotal() > 0);
		$iTT->condicao('condicao->ExistePrazo', $ped->getEndereco()->prazo > 0 && $ped->getItem()->getTotal() > 0);
		$iTT->condicao('condicao->ExisteFreteCorreios', $rs['ativocorreio']);		
		$iTT->trocar("valor.Endereco.Pedido", $ped->freeFrete() ? $idioma->getTraducaoByConteudo('Grátis')->traducao : ($end->getValor()->num > 0 ? "R$ ".$end->getValor()->moeda() : ''));
		$iTT->trocar("tipo.Endereco.Pedido", PedidoEnderecoEntrega::GetNameType($end->tipo));
		$iTT->trocar("prazo.Endereco.Pedido", $ped->getEndereco()->prazo);
		$iTT->trocar("total", "R$ ".Numero::__CreateNumero($total+$end->getValor()->num)->moeda());
		
		$iTT->trocar("observacoes", $ped->observacoes);

	}
	
	
	
	$con = BDConexao::__Abrir();
	$con->executar("SELECT * FROM ".Sistema::$BDPrefixo."pagamentos");
	$rsP = $con->getRegistro();
	$con->executar("SELECT * FROM ".Sistema::$BDPrefixo."frete");
	$rsF = $con->getRegistro();
	
	$pagseguro = true;
	$deposito = true;
	
	if(!$rsP['ativopagseguro'])
		$pagseguro = false;
	if(!$rsP['ativodeposito'])
		$deposito = false;
	
	if($rsF['ativocorreio'] && !$rsF['fretegratis'] && $deposito && !$ped->hasFrete())
		$deposito = false;
	
	if($rsF['ativocorreio'] && !$rsF['fretegratis'] && $pagseguro && !$rsP['fretepagseguro'] && !$ped->hasFrete())
		$pagseguro = false;
		
	if(!$deposito && !$pagseguro){
		$iTT->trocar('erroPagamento', $idioma->getTraducaoByConteudo("Desculpe, mas não há nenhuma forma de pagamento ativa no momento")->traducao);
	}
	
	$iTT->condicao("condicao->PagSeguro.Pagamento", $pagseguro);
	$iTT->condicao("condicao->Deposito.Pagamento", $deposito);
	$iTT->condicao("condicao->Pagamentos", $pagseguro || $deposito);

}

$javaScript .= $iTT->createJavaScript()->concluir();
$includePagina = $iTT->concluir();

?>