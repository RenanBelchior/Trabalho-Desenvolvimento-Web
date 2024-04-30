$(document).ready(function(){
    // Click do carrinho de compras
    $("#cart-sidebar-toggler").click(function(){
        $("#cart-sidebar").toggleClass("open");
    });

    // Fechar o carrinho de compras ao clicar fora dele
    $(document).click(function(event) { 
        if(!$(event.target).closest('#cart-sidebar-toggler, #cart-sidebar').length) {
            if($('#cart-sidebar').hasClass('open')) {
                $('#cart-sidebar').removeClass('open');
            }
        }        
    });

    // Adicionar Produto ao carrinho
    $(".add-to-cart").click(function(e) {
        e.preventDefault();
        var id = $(this).data("id");
        var name = $(this).data("name");
        var price = $(this).data("price");
        addToCart(id, name, price);
    });

    // Função para adicionar produto ao carrinho
    function addToCart(id, name, price) {
        var itemHtml = '<li>'+name+' - R$ '+price+' <button class="btn btn-sm btn-danger remove-from-cart" data-id="'+id+'">Remover</button></li>';
        $("#cart-items").append(itemHtml);
        updateCartTotal();
    }

    // Remover produto do carrinho
    $(document).on("click", ".remove-from-cart", function() {
        var id = $(this).data("id");
        $(this).closest("li").remove();
        updateCartTotal();
    });

    // Atualizar o total do carrinho
    function updateCartTotal() {
        var total = 0;
        $("#cart-items li").each(function() {
            var priceText = $(this).text().split("R$ ")[1];
            total += parseFloat(priceText);
        });
        $("#cart-total").text("Total: R$ "+total.toFixed(2));
    }
});