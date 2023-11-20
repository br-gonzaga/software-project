
Sua consulta SQL está correta para obter os serviços pendentes de confirmação (agendamento = 'Não confirmado'). No entanto, você não precisa usar bind_param nesse caso, já que não há um marcador de posição na sua instrução SQL.

Aqui está o trecho ajustado do seu código PHP:

php
Copy code
<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['email'])) {
    header("Location: login.html");
    exit();
}

// Conexão com o banco de dados
include("criar-conexao-db.php");

// Consulta SQL para obter os serviços pendentes de confirmação 
$sql = "SELECT * FROM tb_agendar_servico WHERE agendamento = 'Não confirmado'";
$result = $conn->query($sql);

// Armazena os resultados em um array para exibição posterior
$agendamentos = [];
while ($row = $result->fetch_assoc()) {
    $agendamentos[] = $row;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style-responsive.css">
    <title>Limpa Já! Deu preguiça é só chamar</title>
</head>
<body>
    <header class="header">
        <h1 class="header-title">Limpa Já!</h1>
    </header>    

    <div class="container">                               
        <div class="content">  
            <h2 class="fieldset-label text-center">Seja bem-vindo <?php echo $_SESSION['nome']; ?>!</h2>                     
            <section class="schedule-section">
                <h2 class="fieldset-label">Confirmar Serviços Agendados</h2>
                <div class="button-container text-center"></br>
                    <form>
                        <table class="agendamentos-table">
                            <thead>
                                <tr>
                                    <th>Tipo de Serviço</th>
                                    <th>Data</th>
                                    <th>Horário</th>
                                    <th>Mensagem Adicional</th>
                                    <th>Status</th>
                                    <th>Ações</th> <!-- Nova coluna para o botão -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($agendamentos as $agendamento): ?>
                                    <tr>
                                        <td><?= $agendamento['tipo_servico'] ?></td>
                                        <td><?= $agendamento['data_servico'] ?></td>
                                        <td><?= $agendamento['horario_servico'] ?></td>
                                        <td><?= isset($agendamento['mensagem']) ? $agendamento['mensagem'] : '' ?></td>
                                        <td><?= $agendamento['agendamento'] ?></td>
                                        <td>
                                            <button type="button" class="btn btn-success" onclick="confirmarServico(<?= $agendamento['id_servico'] ?>)">Confirmar</button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </form>
                </div>
            </section>
            <div id="user-info" class="text-center"></br>                                   
                <a href="logout.php" class="btn btn-danger">Sair</a>
            </div>
        </div>
    </div>
    
    
</body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="funcoes.js"></script>

</html>
