<?php
session_start(); // Inicia a sessão

// Destrói todas as variáveis da sessão
session_unset();

// Finaliza a sessão
session_destroy();

// Redireciona para a tela de login
header("Location: ../global_html/paginaEntrar.html");
exit();
?>