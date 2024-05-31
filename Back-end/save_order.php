<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ecommerce";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}


$nome = $_POST['nome'];
$contato = $_POST['contato'];
$municipio = $_POST['municipio'];
$bairro = $_POST['bairro'];
$rua = $_POST['rua'];
$numero = $_POST['numero'];
$formaPagamento = $_POST['forma_pagamento'];
$itens = $_POST['itens']; 


$sql = "INSERT INTO pedidos (nome, contato, municipio, bairro, rua, numero, forma_pagamento) 
        VALUES ('$nome', '$contato', '$municipio', '$bairro', '$rua', '$numero', '$formaPagamento')";

if ($conn->query($sql) === TRUE) {
    $pedido_id = $conn->insert_id; 
    foreach ($itens as $item) {
        $produto_nome = $item['nome'];
        $preco = $item['preco'];
        $sql = "INSERT INTO itens_pedido (pedido_id, produto_nome, preco) 
                VALUES ('$pedido_id', '$produto_nome', '$preco')";
        $conn->query($sql);
    }
    echo "Pedido salvo com sucesso!";
} else {
    echo "Erro: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>