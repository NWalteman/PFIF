<?php
// Inclui o arquivo de conexão com o banco de dados
require_once '../global_php/conexao.php';

// Verifica se os dados foram enviados via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Verifica se os campos estão preenchidos
    if (empty($email) || empty($senha)) {
        header("Location: index.php?erro=2"); // Redireciona com erro 2 (campos vazios)
        exit();
    }

    // Consulta no banco de dados
    $sql = "SELECT * FROM administrador WHERE email = ? AND senha = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ss", $email, $senha);
    $stmt->execute();
    $resultado = $stmt->get_result();

    // Verifica se encontrou o usuário
    if ($resultado->num_rows > 0) {
        // Login bem-sucedido
        session_start();
        $dados = $resultado->fetch_assoc();
        $_SESSION['id'] = $dados['id'];
        $_SESSION['nome'] = $dados['nome'];
        header("Location: paginaInicial.php"); // Redireciona para o painel
    } else {
        // Login falhou
        header("Location: paginaLoginAdm.php"); // Redireciona com erro 1 (dados inválidos)
    }

    $stmt->close();
}

$mysqli->close();
?>
