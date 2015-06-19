<?php

importar("Utilidades.Noticias.Lista.ListaNoticiaCategorias");
importar("Utilidades.Noticias.Lista.ListaNoticias");

$iTT = new InterFaces(new Arquivos(Sistema::$layoutCaminhoDiretorio."noticia.html"));
$iTT->trocar("url",     $url);
$iTT->trocar("lang",    $_SESSION['lang']);

$nC = $lNC->listar();
$n  = $lN->listar();

$titulo     = $n->getTexto()->titulo;
$descricao  = $n->getTexto()->subTitulo;

if($lNC->getTotal() > 0)
    $iTT->trocar('navegador.NoticiaCategoria', "<a href='".Sistema::$caminhoURL.$_SESSION['lang']."/noticias/{$nC->getURL()->url}'>{$nC->getTexto()->titulo}</a> > {$n->getTexto()->titulo}");
else
    $iTT->trocar('navegador.NoticiaCategoria', "<a href='".Sistema::$caminhoURL.$_SESSION['lang']."/noticias'>Noticias</a> > {$n->getTexto()->titulo}");

$img = $n->getTexto()->getImagem();
$iTT->condicao('condicao->imagens', $img->getImage()->nome != "");
if($img->getImage()->nome != "")
    $iTT->trocar('url.Imagem', $img->getImage()->pathImage(700, 550));

$iTT->trocar("url.Noticia", $n->getURL()->url);
$iTT->trocar("titulo",      $n->getTexto()->titulo);
$iTT->trocar("subTitulo",   $n->getTexto()->subTitulo);
$iTT->trocar("texto",       $n->getTexto()->texto);

include("lateral-direita.php");
$iTT->trocar("lateralDireita", $lateralDireita);

$includePagina = $iTT->concluir();