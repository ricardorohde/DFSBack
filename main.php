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

//include('lateral-direita.php');
//$iTM->trocar('lateralDireita', $lateralDireita);

$javaScript .= $iTM->createJavaScript()->concluir();

$includePagina = $iTM->concluir();

?>