<?php
// Conexão com o banco de dados
include("criar-conexao-db.php");

// Verifica se o formulário foi submetido
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recupera os valores do formulário
    $perfil = $_POST['perfil'];

    $lavar_roupa = isset($_POST['lavar-roupa']) ? 1 : 0;
    $passar_roupa = isset($_POST['passar-roupa']) ? 1 : 0;
    $limpar_casa = isset($_POST['limpar-casa']) ? 1 : 0;

    $nome = $_POST['nome'];
    $sobrenome = $_POST['sobrenome'];
    $apelido = $_POST['apelido'];
    $data_nascimento = $_POST['data_nascimento'];
    $cpf = preg_replace('/\D/', '', $_POST['cpf']); // Remove caracteres não numéricos
    $telefone = preg_replace('/\D/', '', $_POST['telefone']); // Remove caracteres não numéricos
    $celular = preg_replace('/\D/', '', $_POST['celular']); // Remove caracteres não numéricos
    $cep = preg_replace('/\D/', '', $_POST['cep']); // Remove caracteres não numéricos
    $rua = $_POST['rua'];
    $numero = $_POST['numero'];
    $bairro = $_POST['bairro'];
    $cidade = $_POST['cidade'];
    $estado = $_POST['estado'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Concatenação dos campos para formar o endereço
    $endereco = $rua . ', ' . $numero . ', ' . $bairro . ', ' . $cidade . ', ' . $estado . ' ' . $cep;

    // Montar a consulta SQL com declaração preparada
    $query = "INSERT INTO tb_cadastro_de_usuarios (perfil, lavar_roupa, passar_roupa, limpar_casa, nome, sobrenome, apelido, data_nascimento, cpf, telefone, celular, cep, rua, numero, bairro, cidade, estado, email, senha, endereco) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($query);

    // Verifica se a preparação da declaração foi bem-sucedida
    if ($stmt) {
        $stmt->bind_param("siiissssssssssssssss", $perfil, $lavar_roupa, $passar_roupa, $limpar_casa, $nome, $sobrenome, $apelido, $data_nascimento, $cpf, $telefone, $celular, $cep, $rua, $numero, $bairro, $cidade, $estado, $email, $senha, $endereco);

        // Executar a consulta
        if ($stmt->execute()) {
            
            // Redirecionamento para login.html após 5 segundos
            echo '<p>Registro inserido com sucesso! Redirecionando para login.html...</p>';
            echo '<script>
                    setTimeout(function() {
                        window.location.href = "login.html";
                    }, 5000); // 5000 milissegundos = 5 segundos
                  </script>';
            exit();

        } else {
            echo "Erro ao inserir o registro: " . $stmt->error;
        }

        // Feche a declaração
        $stmt->close();
    } else {
        echo "Erro na preparação da consulta: " . $conn->error;
    }

    // Feche a conexão
    $conn->close();
}
?>
