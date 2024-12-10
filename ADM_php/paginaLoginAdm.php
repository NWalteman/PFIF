<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8"> <!-- Define o charset como UTF-8 para garantir que caracteres acentuados sejam exibidos corretamente -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Garante que a página seja responsiva em dispositivos móveis -->
    <title>Login Administrativo - PFIF</title> <!-- Título da página -->
    <link rel="stylesheet" href="../ADM_css/login.css"> <!-- Vincula o arquivo CSS da página para estilizar o layout -->
</head>

<body>
    <!-- Container do Formulário de Login -->
    <div class="login-container">
        <img src="../midia/logoPFIF.png" alt="Logo PFIF"> <!-- Exibe o logo da plataforma -->
        <h2>Login Administrativo</h2> <!-- Título do formulário de login -->
        
        <!-- Formulário de Login -->
        <form name="form1" action="validar_login.php" method="POST">
            <input type="text" placeholder="Digite seu e-mail" name="email" required> <!-- Campo de e-mail (obrigatório) -->
            <input type="password" placeholder="Digite sua senha" name="senha" required> <!-- Campo de senha (obrigatório) -->
            <button type="submit" class="login-button">ENTRAR</button> <!-- Botão de envio para validar login -->
        </form>
    </div>

    <!-- Exibição de Mensagens de Erro -->
    <?php
    // Verifica se há um parâmetro 'erro' na URL e exibe a mensagem correspondente
    if (!empty($_GET["erro"])) {
        if ($_GET["erro"] == 1) {
            // Caso o erro seja 1, exibe uma mensagem de erro para e-mail/senha inválidos
            echo '<div class="alert alert-dark" role="alert"><strong>Erro: </strong> E-mail/senha inválidos.</div>';
        } elseif ($_GET["erro"] == 2) {
            // Caso o erro seja 2, exibe uma mensagem de erro para campos obrigatórios não preenchidos
            echo '<div class="alert alert-dark" role="alert"><strong>Erro: </strong> Você deve informar os campos Login e Senha.</div>';
        }
    }
    ?>

</body>

</html>
