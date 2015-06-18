<?php

importar("Utilidades.Publicidades.Banners.Lista.ListaBannerCategorias");
importar("LojaVirtual.Pedidos.Pagamentos.PagamentoPagSeguro");
importar("LojaVirtual.Categorias.Lista.ListaProdutoCategorias");
importar("LojaVirtual.Produtos.ProdutoBusca");

$iTM = new InterFaces(new Arquivos(Sistema::$layoutCaminhoDiretorio."main.html"));

$iTM->setSESSION($_SESSION);
$iTM->trocar('lang', $_SESSION['lang']);

/**
 * Vai pegar todos os produtos que pertencem
 * às categorias que possuem
 * visaounica = 1
 */

$pCP = new ProdutoCategoria;
$cond[1] = array('campo' => ListaProdutoCategorias::VISAOUNICA, 'valor' => ListaProdutoCategorias::VALOR_VISAOUNICA_TRUE);
$pCP->getSubCategorias()->condicoes($cond);unset($cond);

$lt = $pCP->getSubCategorias();


$iTM->condicao('condicao->PrincipaisCategorias', $lt->getTotal());
$iTM->createRepeticao('repetir->ProdutoCategorias');

$produtos = array();
while($l = $lt->listar()) {

    $iTM->repetir();
    $iTM->enterRepeticao()->trocar('nome.ProdutoCategoria', $l->nome);
    $iTM->enterRepeticao()->trocar('linkVisualizar.ProdutoCategoria',Sistema::$caminhoURL.$_SESSION['lang']."/produtos/".$l->getURL()->url);
}

$lP = new ListaProdutos;
$cond[1] = array('campo' => ListaProdutos::DISPONIVEL, 'valor' => ListaProdutos::VALOR_DISPONIVEL_TRUE);
$cond[2] = array('campo' => ListaProdutos::DESTAQUE, 'valor' => ListaProdutos::VALOR_DISPONIVEL_TRUE);
$cond[3] = array('campo' => ListaProdutos::REMOVIDO, 'valor' => ListaProdutos::VALOR_DISPONIVEL_FALSE);
$cond[4] = array('campo' => ListaProdutos::DESTAQUE, 'valor' => ListaProdutos::VALOR_DESTAQUE_TRUE);
$lP->condicoes($cond);unset($cond);


while($p = $lP->listar()) {
    if($p->getImagens()->getTotal() > 0){
        $img = $p->getImagens()->listar("DESC", ListaImagens::DESTAQUE);
        if($img->getImage()->nome != ''){
            $width = $img->getImage()->original_width;
            $height = $img->getImage()->original_height;



            /** Adiciona 20% ao valor da largura e
             * verifica se dessa forma, é maior ou
             * menor que a altura para poder
             * fazer o efeito de blocos na home.
             */

            if($p->getCategorias()->getTotal() > 0) {
                $width = ($width * 0.2 + $width);
                $linkVisualizar = Sistema::$caminhoURL . $_SESSION['lang'] . "/produtos/" . $p->getCategorias()->listar()->getURL()->url . "/" . $p->getURL()->url;
                $produtos[$p->getId()] = array(
                    'image_url' => $img->getImage()->pathImage(500, 500),
                    'nome' => $p->nome,
                    'url' => $linkVisualizar,
                    'image_width' => $width,
                    'image_height' => $height
                );
            }
        }
    }
}

$pCP->close();
$lP->close();

ksort($produtos);
$iTM->createRepeticao('repetir->PrincipaisProdutos');

foreach($produtos as $prd) {
    $iTM->repetir();

    $iTM->enterRepeticao()->condicao('condicao->width.image', $prd['image_width']>$prd['image_height']);
    $iTM->enterRepeticao()->condicao('condicao->!width.image', $prd['image_width']<=$prd['image_height']);

    $iTM->enterRepeticao()->trocar('PrincipaisProdutos.Produto.Imagem',$prd['image_url']);
    $iTM->enterRepeticao()->trocar('PrincipaisProdutos.Produto.Nome',$prd['nome']);
    $iTM->enterRepeticao()->trocar('PrincipaisProdutos.Produto.URL',$prd['url']);
}

# Lista as Marcas
$lM = new ListaProdutoMarcas();
$cond[1] = array('campo' => ListaProdutoMarcas::DISPONIVEL, 'valor' => ListaProdutoMarcas::VALOR_DISPONIVEL_TRUE);
$lM->condicoes($cond);unset($cond);
$lM->setParametros(15,'limite');

$iTM->condicao('condicao->Marcas', $lM->getTotal() > 0);
$iTM->createRepeticao('repetir->Marcas');
while($m = $lM->listar()) {
    $iTM->repetir();

    $iTM->enterRepeticao()->trocar('Marcas.Nome', $m->nome);
    $iTM->enterRepeticao()->trocar('Marcas.Imagem', $m->getImagem()->pathImage(100,100));
    $iTM->enterRepeticao()->trocar('Marcas.URL', Sistema::$caminhoURL.$_SESSION['lang']."/produtos/&marca=".$m->getURL()->url);
}

# Lista os Produtos Mais Visualizados
$lPMV = new ListaProdutos();
$cond[1] = array('campo' => ListaProdutos::DISPONIVEL, 'valor' =>ListaProdutos::VALOR_DISPONIVEL_TRUE);
$lPMV->condicoes($cond);unset($cond);
$lPMV->setParametros(15,'limite');

$iTM->condicao('condicao->ProdutosMaisVisualizados', $lPMV->getTotal() > 0);
$iTM->createRepeticao('repetir->ProdutosMaisVisualizados');
while($pmv = $lPMV->listar('DESC',ListaProdutos::VIEW)) {
    if($pmv->getCategorias()->getTotal() > 0) {
        $iTM->repetir();

        $iTM->enterRepeticao()->trocar('ProdutosMV.Nome', $idioma->getTraducaoByConteudo($pmv->nome)->traducao);
        $iTM->enterRepeticao()->trocar('ProdutosMV.URL', Sistema::$caminhoURL . $_SESSION['lang'] . "/produtos/" . $pmv->getCategorias()->listar()->getURL()->url . "/" . $pmv->getURL()->url);
        $iTM->enterRepeticao()->trocar('ProdutosMV.Imagem', $pmv->getImagens()->listar("DESC", ListaImagens::DESTAQUE)->getImage()->pathImage(150,150));
    }
}
$lPMV->close();

# lista os Produtos em Ofertas
$lPO = new ListaProdutos();
$cond[1] = array('campo' => ListaProdutos::VALORVENDA, 'valor' => 0, 'operador' => '>');
$cond[2] = array('campo' => ListaProdutos::DISPONIVEL, 'valor' => ListaProdutos::VALOR_PROMOCAO_TRUE);
$lPO->condicoes($cond);unset($cond);

$iTM->condicao('condicao->Produtos.Oferta', $lPO->getTotal() > 0);
$iTM->createRepeticao('repetir->Produtos.Oferta');
while($po = $lPO->listar('DESC',ListaProdutos::ID)) {
    if($po->getCategorias()->getTotal() > 0) {
        $iTM->repetir();

        $iTM->enterRepeticao()->trocar('Produtos.Ofertas.Nome', $idioma->getTraducaoByConteudo($po->nome)->traducao);
        $iTM->enterRepeticao()->trocar('Produtos.Ofertas.URL', Sistema::$caminhoURL . $_SESSION['lang'] . "/produtos/" . $po->getCategorias()->listar()->getURL()->url . "/" . $po->getURL()->url);
        $iTM->enterRepeticao()->trocar('Produtos.Ofertas.Imagem', $po->getImagens()->listar("DESC", ListaImagens::DESTAQUE)->getImage()->pathImage(120,120));

        $iTM->enterRepeticao()->trocar('Produtos.Ofertas.Valor',  "U$ ".$po->valorReal->moeda());
        $iTM->enterRepeticao()->trocar('Produtos.Ofertas.ValorPromocional',  "U$ ".$po->valorVenda->moeda());
    }
}


$javaScript .= $iTM->createJavaScript()->concluir();

$includePagina = $iTM->concluir();

?>