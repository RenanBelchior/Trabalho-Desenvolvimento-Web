<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Pedido</title>
    <style>
    </style>
</head>
<body>
    <h1>Detalhes do Pedido</h1>
    <?php
    if (isset($_GET['id'])) {
        $pedido_id = $_GET['id'];
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "ecommerce";

        
        $conn = new mysqli($servername, $username, $password, $dbname);

        
        if ($conn->connect_error) {
            die("Falha na conexão: " . $conn->connect_error);
        }

        
        $sql = "SELECT * FROM pedidos WHERE id = $pedido_id";
        $result = $conn->query($sql);

        
        if ($result->num_rows > 0) {
            $pedido = $result->fetch_assoc();
            echo "<p><strong>ID do Pedido:</strong> " . $pedido['id'] . "</p>";
            echo "<p><strong>Nome do Cliente:</strong> " . $pedido['nome'] . "</p>";
            echo "<p><strong>Contato:</strong> " . $pedido['contato'] . "</p>";
            echo "<p><strong>Município:</strong> " . $pedido['municipio'] . "</p>";
            echo "<p><strong>Bairro:</strong> " . $pedido['bairro'] . "</p>";
            echo "<p><strong>Rua:</strong> " . $pedido['rua'] . "</p>";
            echo "<p><strong>Número:</strong> " . $pedido['numero'] . "</p>";
            echo "<p><strong>Forma de Pagamento:</strong> " . $pedido['forma_pagamento'] . "</p>";

            
            $sql_itens = "SELECT * FROM itens_pedido WHERE pedido_id = $pedido_id";
            $result_itens = $conn->query($sql_itens);

            
            if ($result_itens->num_rows > 0) {
                echo "<h2>Itens do Pedido</h2>";
                echo "<ul>";
                while ($item = $result_itens->fetch_assoc()) {
                    echo "<li>" . $item['produto_nome'] . " - R$ " . $item['preco'] . "</li>";
                }
                echo "</ul>";
            } else {
                echo "<p>Nenhum item encontrado para este pedido.</p>";
            }
        } else {
            echo "<p>Pedido não encontrado.</p>";
        }

        $conn->close();
    } else {
        echo "<p>Erro: ID do pedido não foi especificado.</p>";
    }
    ?>
</body>
</html>
