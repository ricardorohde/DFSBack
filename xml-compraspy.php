<?php

include('lib.conf/includes.php');

importar("LojaVirtual.Produtos.Lista.ListaProdutos");

header("Content-type: text/xml; charset=iso-8859-1");

$xml = new SimpleXMLElement('<rss version="2.0"></rss>');

$channel = $xml->addChild("channel");

$channel->addChild("title", 'Produtos da Pioneer Internacional');
$channel->addChild("link", 'http://www.pioneerinter.com');
$channel->addChild("description", ('Feed contendo os atributos obrigatórios e recomendados para cada produto da loja Pioneer Internacional'));

$con = BDConexao::__Abrir();

$con->executar("SELECT id FROM ".Sistema::$BDPrefixo."produtos WHERE disponivel = 1 ORDER BY nome ASC");
while($rs = $con->getRegistro()){
	
	$lP = new ListaProdutos;
	$lP->condicoes("", $rs['id'], ListaProdutos::ID);
	if($lP->getTotal() > 0){
		
		$p = $lP->listar();
		
		if($p->getCategorias()->getTotal() > 0){

            $item = $channel->addChild("item");
			
			$pC = $p->getCategorias()->listar();
			
			$item->addChild("title", $p->nome);
			$item->addChild("link", Sistema::$caminhoURL.'br/produtos/'.$pC->getURL()->url."/".$p->getURL()->url);
			$item->addChild("description", utf8_encode(strip_tags($p->descricao)));
			$item->addChild("codigo", $p->codigo);
			$item->addChild("preco", $p->valorReal->formatar()." USD");
			if($p->getImagens()->getTotal() > 0){
				$img = $p->getImagens()->listar("DESC", ListaImagens::DESTAQUE);
				$item->addChild("link_imagem", Sistema::$caminhoURL.Sistema::$caminhoDataProdutos.$img->getImage()->nome.".".$img->getImage()->extensao);
			}else
				$item->addChild("link_imagem", "");
				
			$item->addChild("disponibilidade", "em estoque");
		
		}
	
	}
	
}

echo @$xml->asXML();