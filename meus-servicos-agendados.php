<?php
session_start();

// Verificar se o usuário está autenticado
if (!isset($_SESSION['email'])) {
    header("Location: login.html");
    exit();
}

// Conectar ao banco de dados
include("criar-conexao-db.php");

// Recuperar o email do usuário da sessão
$emailUsuario = $_SESSION['email'];

// Consulta SQL para obter os serviços agendados do usuário logado
$sql = "SELECT * FROM tb_servicos_agendados WHERE email_usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $emailUsuario);
$stmt->execute();
$result = $stmt->get_result();

// Fechar a conexão, pois já obtivemos os resultados
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style-responsive.css">
    <title>Limpa Já! Meus Serviços Agendados</title>
</head>
<body>
    <header class="header">
        <h1 class="header-title">Limpa Já!</h1>
    </header>

    <div class="container">
        <div class="content">
            <h2 class="fieldset-label text-center">Meus Serviços Agendados</h2><br>

            <?php
            // Loop através dos resultados da consulta
            while ($row = $result->fetch_assoc()) {
                echo '<div class="card">';
                echo '<div class="card-body">';
                echo '<h5 class="card-title">' . $row['tipo_servico'] . '</h5>';
                echo '<p class="card-text">Data: ' . $row['data_servico'] . ', Horário: ' . $row['horario_servico'] . '</p>';
                echo '<p class="card-text">Mensagem Adicional: ' . $row['mensagem_adicional'] . '</p>';
                echo '</div>';
                echo '</div>';
            }
            ?>

        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="funcoes.js"></script>
    <script src="validacoes.js"></script>
</body>
</html>
