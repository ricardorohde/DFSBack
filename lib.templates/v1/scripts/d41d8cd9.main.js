$(function(){
    $('#TopoCarousel').owlCarousel({items:1,responsive:true,singleItem:true,autoHeight : true});
    $('#MarcasCarousel').owlCarousel({items:5, reponsive: true});
    $('#ProdutosMVCarousel').owlCarousel({items:5, reponsive: true});
    $('#ProdutosOfertasCarousel').owlCarousel({items:5, reponsive: true});


    $('.disabled').on('click',function(e) {
        e.preventDefault();
    })
});