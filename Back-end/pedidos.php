<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Pedidos</title>
    <style>
    </style>
</head>
<body>
    <h1>Lista de Pedidos</h1>
    <table>
        <thead>
            <tr>
                <th>ID do Pedido</th>
                <th>Nome do Cliente</th>
                <th>Contato</th>
                <th>Município</th>
                <th>Bairro</th>
                <th>Rua</th>
                <th>Número</th>
                <th>Forma de Pagamento</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
           
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "ecommerce";

            
            $conn = new mysqli($servername, $username, $password, $dbname);

           
            if ($conn->connect_error) {
                die("Falha na conexão: " . $conn->connect_error);
            }

            
            $sql = "SELECT * FROM pedidos";
            $result = $conn->query($sql);

            
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['nome'] . "</td>";
                    echo "<td>" . $row['contato'] . "</td>";
                    echo "<td>" . $row['municipio'] . "</td>";
                    echo "<td>" . $row['bairro'] . "</td>";
                    echo "<td>" . $row['rua'] . "</td>";
                    echo "<td>" . $row['numero'] . "</td>";
                    echo "<td>" . $row['forma_pagamento'] . "</td>";
                    echo "<td><a href='detalhes_pedido.php?id=" . $row['id'] . "'>Detalhes</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='9'>Nenhum pedido encontrado</td></tr>";
            }

            $conn->close();
            ?>
        </tbody>
    </table>
</body>
</html>