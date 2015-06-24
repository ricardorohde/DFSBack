$(function(){
    $('#TopoCarousel').owlCarousel({
        items:1,
        responsive:true,
        singleItem:true,
        autoHeight : true
    });
    $('#ProdutosMVCarousel').owlCarousel({
        items:5,
        singleItem:false,
        autoHeight : true,
        itemsTablet: [600,2],
        itemsMobile: [479,3]
    });
    $('#ProdutosOfertasCarousel').owlCarousel({
        items:5,
        singleItem:false,
        autoHeight : true,
        itemsTablet: [600,2],
        itemsMobile: [479,3]
    });
    $('#MarcasCarousel').owlCarousel({
        items:5,
        singleItem:false,
        autoHeight : true,
        itemsTablet: [600,2],
        itemsMobile: [479,3]
    });

    $('.disabled').on('click',function(e) {
        e.preventDefault();
    });
});