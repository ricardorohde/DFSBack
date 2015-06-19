<?php

importar("Utilidades.Noticias.Lista.ListaNoticiaCategorias");
importar("Utilidades.Noticias.Lista.ListaNoticias");

$lN = new ListaNoticias;
if(!empty($_GET['noticia']))
    $lN->condicoes('', $_GET['noticia'], ListaNoticias::ID);
elseif(!empty($pagina)){

    $lU = new ListaURLs;

    $cond[1] = array('campo' => ListaURLs::URL, 	'valor' => $pagina);
    $cond[2] = array('campo' => ListaURLs::TABELA, 	'valor' => $lN->getTabela());

    if($lU->condicoes($cond)->getTotal() > 0){
        $lN->condicoes('', $lU->listar()->valor, ListaNoticias::ID);
    }

}

$lNC = new ListaNoticiaCategorias;
if(!empty($_GET['cat']))
    $lN->condicoes('', $_GET['cat'], ListaNoticiaCategorias::ID);
elseif(!empty($pagina)){

    $lU = new ListaURLs;

    $cond[1] = array('campo' => ListaURLs::URL, 	'valor' => $pagina);
    $cond[2] = array('campo' => ListaURLs::TABELA, 	'valor' => $lNC->getTabela());

    if($lU->condicoes($cond)->getTotal() > 0){
        $lNC->condicoes('', $lU->listar()->valor, ListaNoticiaCategorias::ID);
    }

}

if($lN->getTotal() > 0){

    include("detalhesnoticia.php");

}else {

    if(!empty($_GET['noticia']))
        $lN->condicoes('', $_GET['noticia'], ListaNoticias::ID);
    elseif(!empty($procura2)){

        $lU = new ListaURLs;

        $cond[1] = array('campo' => ListaURLs::URL, 	'valor' => $procura2);
        $cond[2] = array('campo' => ListaURLs::TABELA, 	'valor' => $lN->getTabela());

        if($lU->condicoes($cond)->getTotal() > 0){
            $lN->condicoes('', $lU->listar()->valor, ListaNoticias::ID);
        }

    }

    if($lN->getTotal() > 0) {

        include("detalhesnoticia.php");

    }else {

        $iTT = new InterFaces(new Arquivos(Sistema::$layoutCaminhoDiretorio . "noticias.html"));

        if($lNC->getTotal() == "")
            $iTT->trocar("titulo.NoticiaCategoria", "Noticias");
        else {
            $nC = $lNC->listar();
            $lN = $nC->getNoticias();
            $iTT->trocar("titulo.NoticiaCategoria", $nC->getTexto()->titulo);
        }
        $titulo = $lNC->getTotal() > 0 ? $nC->getTexto()->titulo : "Notícias";
        $descricao = $lNC->getTotal() > 0 ? strip_tags($nC->getTexto()->descricao) : "";

        if($lN->getTotal() === null)
            $lN->condicoes();

        $total      = $lN->getTotal();
        $por        = 6;
        $paginas    = 10;
        $minimo     = $_GET['pag']*$por;
        $maximo     = $minimo+$por;

        $lN->setParametros($minimo)->setParametros($maximo, 'limite');
        $iTT->createRepeticao("repetir->Noticias");
        while ($n = $lN->listar()) {

            $iTT->repetir();

            $iTT->enterRepeticao()->trocar('titulo.Noticia', $n->getTexto()->titulo);
            $iTT->enterRepeticao()->trocar('subTitulo.Noticia', $n->getTexto()->subTitulo);
            $iTT->enterRepeticao()->trocar('texto.Noticia', $n->getTexto()->texto);

            $iTT->enterRepeticao()->trocar('linkVisualizar.Noticia', Sistema::$caminhoURL.$_SESSION['lang']."/noticias".($lNC->getTotal() > 0 ? "/".$nC->getURL()->url : "")."/".$n->getURL()->url);

            if ($n->getTexto()->getImagem()->getImage()->nome != '')
                $iTT->enterRepeticao()->trocar("url.Imagem.Noticia", $n->getTexto()->getImagem()->getImage()->pathImage(390, 218));

        }

        //Paginador
        $max = number_format($total/$por);
        if($max < $total/$por) $max++;
        if($max > $paginas){
            $paginas2 = (int) ($paginas/2);
            $inicioPaginas = (($_GET['pag']+1)-$paginas2 < 1) ? 1 : (is_float($paginas/2) ? ($_GET['pag']+1)-($paginas2) : ($_GET['pag']+1)-($paginas2-1));
            $fimPaginas = ($inicioPaginas+$paginas-1 > $max) ? $max : $inicioPaginas+$paginas-1;
            $inicioPaginas += (($_GET['pag']+1) > $fimPaginas-($paginas2) && is_float($paginas/2)) ? ($fimPaginas-$paginas2)-($_GET['pag']+1) : 0;
        }else{
            $inicioPaginas = 1;
            $fimPaginas = $max;
        }

        $iTT->condicao('condicao->Paginador.Noticias', $max > 1);
        $iTT->createRepeticao('repetir->Paginador.Noticias');

        for($i = $inicioPaginas; $i <= $fimPaginas; $i++){

            $iTT->repetir('repetir->Paginador.Noticias');

            $iTT->enterRepeticao('repetir->Paginador.Noticias')->condicao('condicao->Selecionada.Pagina.Noticias', $i-1 == $_GET['pag']);
            $iTT->enterRepeticao('repetir->Paginador.Noticias')->trocar('numero.Pagina.Noticias', $i);
            $iTT->enterRepeticao('repetir->Paginador.Noticias')->trocar('linkVisualizar.Pagina.Noticias', Sistema::$caminhoURL.$_SESSION['lang']."/noticias".(!empty($procura) ? "/".$procura."/" : '/')."&pag=".($i-1)."&busca=".$_GET['busca']);

        }

        $iTT->condicao('condicao->Anterior.Paginador.Noticias', $_GET['pag']+1 > 1);
        $iTT->condicao('condicao->Proximo.Paginador.Noticias', $_GET['pag']+1 < $max);
        $iTT->trocar('linkVisualizar.Anterior.Paginador.Noticias', Sistema::$caminhoURL.$_SESSION['lang']."/noticias".(!empty($procura) ? "/".$procura."/" : '/')."&pag=".($_GET['pag']-1)."&busca=".$_GET['busca']);
        $iTT->trocar('linkVisualizar.Proximo.Paginador.Noticias', Sistema::$caminhoURL.$_SESSION['lang']."/noticias".(!empty($procura) ? "/".$procura."/" : '/')."&pag=".($_GET['pag']+1)."&busca=".$_GET['busca']);
        //

        include("lateral-direita.php");
        $iTT->trocar("lateralDireita", $lateralDireita);

        $includePagina = $iTT->concluir();

    }

}