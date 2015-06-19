$(function(){
    $('#TopoCarousel').owlCarousel({items:1,responsive:true,singleItem:true,autoHeight : true});

    $('.disabled').on('click',function(e) {
        e.preventDefault();
    })
});