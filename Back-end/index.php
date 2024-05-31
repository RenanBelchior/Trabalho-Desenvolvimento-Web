<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ecommerce";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}


if(isset($_GET['delete_id']) && !empty($_GET['delete_id'])){
    $pedido_id = $_GET['delete_id'];
    
    
    $sql_delete = "DELETE FROM pedidos WHERE id = $pedido_id";

    if ($conn->query($sql_delete) === TRUE) {
        
        header("Location: index.php");
        exit;
    } else {
        echo "Erro ao excluir o pedido: " . $conn->error;
    }
}


$sql = "SELECT p.id, p.nome, p.contato, p.municipio, p.bairro, p.rua, p.numero, p.forma_pagamento, 
        GROUP_CONCAT(i.produto_nome, ' - R$', i.preco SEPARATOR '<br>') as itens 
        FROM pedidos p 
        LEFT JOIN itens_pedido i ON p.id = i.pedido_id 
        GROUP BY p.id";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de Pedidos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 90%;
            margin: auto;
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #343a40;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            border: 1px solid #dee2e6;
            text-align: left;
        }
        th {
            background-color: #343a40;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .actions button {
            background-color: #343a40;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }
        .actions button:hover {
            background-color: #495057;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Gerenciamento de Pedidos</h1>
        <table>
            <thead>
                <tr>
                    <th>ID do Pedido</th>
                    <th>Nome</th>
                    <th>Contato</th>
                    <th>Município</th>
                    <th>Bairro</th>
                    <th>Rua</th>
                    <th>Número</th>
                    <th>Forma de Pagamento</th>
                    <th>Itens</th>
                    <th>Ações</th> 
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['nome'] . "</td>";
                        echo "<td>" . $row['contato'] . "</td>";
                        echo "<td>" . $row['municipio'] . "</td>";
                        echo "<td>" . $row['bairro'] . "</td>";
                        echo "<td>" . $row['rua'] . "</td>";
                        echo "<td>" . $row['numero'] . "</td>";
                        echo "<td>" . $row['forma_pagamento'] . "</td>";
                        echo "<td>" . $row['itens'] . "</td>";
                        echo "<td><a href='index.php?delete_id=" . $row['id'] . "' onclick=\"return confirm('Tem certeza que deseja excluir este pedido?');\">Excluir</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='10'>Nenhum pedido encontrado</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
