$(function(){
    $('#TopoCarousel').owlCarousel({items:1,responsive:true,singleItem:true,autoHeight : true});
    $('#ProdutosMVCarousel').owlCarousel({items:5,responsive:true,singleItem:false,autoHeight : true});
    $('#ProdutosOfertasCarousel').owlCarousel({items:5,responsive:true,singleItem:false,autoHeight : true});
    $('#MarcasCarousel').owlCarousel({items:5,responsive:true,singleItem:false,autoHeight : true});

    $('.disabled').on('click',function(e) {
        e.preventDefault();
    })
});