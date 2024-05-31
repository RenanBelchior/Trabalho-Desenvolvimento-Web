$(document).ready(function(){
    
    $("#cart-sidebar-toggler").click(function(){
        $("#cart-sidebar").toggleClass("open");
    });

    
    $(document).click(function(event) { 
        if(!$(event.target).closest('#cart-sidebar-toggler, #cart-sidebar').length) {
            if($('#cart-sidebar').hasClass('open')) {
                $('#cart-sidebar').removeClass('open');
            }
        }        
    });

   
    $(".add-to-cart").click(function(e) {
        e.preventDefault();
        var id = $(this).data("id");
        var name = $(this).data("name");
        var price = $(this).data("price");
        addToCart(id, name, price);
    });

    
    function addToCart(id, name, price) {
        var itemHtml = '<li data-id="'+id+'">'+name+' - R$ '+price+' <button class="btn btn-sm btn-danger remove-from-cart">Remover</button></li>';
        $("#cart-items").append(itemHtml);
        updateCartTotal();
    }

    
    $(document).on("click", ".remove-from-cart", function() {
        var id = $(this).closest("li").data("id");
        $(this).closest("li").remove();
        updateCartTotal();
    });

    
    function updateCartTotal() {
        var total = 0;
        $("#cart-items li").each(function() {
            var priceText = $(this).text().split("R$ ")[1];
            total += parseFloat(priceText);
        });
        $("#cart-total").text("Total: R$ "+total.toFixed(2));
    }


$('#checkoutForm').submit(function(event){
    event.preventDefault(); 
    var nome = $('#nome').val();
    var contato = $('#contato').val();
    var municipio = $('#municipio').val();
    var bairro = $('#bairro').val();
    var rua = $('#rua').val();
    var numero = $('#numero').val();
    var formaPagamento = $('#forma_pagamento').val();

    
    var itens = [];
    $("#cart-items li").each(function() {
        var id = $(this).data("id");
        var name = $(this).text().split(" - R$ ")[0];
        var price = $(this).text().split(" - R$ ")[1];
        itens.push({id: id, nome: name, preco: price});
    });

    
    $.ajax({
        type: "POST",
        url: "save_order.php",
        data: { 
            nome: nome,
            contato: contato,
            municipio: municipio,
            bairro: bairro,
            rua: rua,
            numero: numero,
            forma_pagamento: formaPagamento,
            itens: itens
        },
        success: function(response) {
            console.log("Pedido realizado com sucesso!");
            console.log(response); 
            window.location.href = 'confirmacao.html';
        },
        error: function(xhr, status, error) {
            console.error("Erro ao enviar pedido: " + xhr.status + " - " + xhr.statusText);
            console.error(xhr.responseText); 
        }
    });
  });
});