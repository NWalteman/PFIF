<?php
// Verifica se o ID foi fornecido na URL
if (!empty($_GET["id"])) {
    // Inclui o arquivo de conexão com o banco de dados
    require_once "../global_php/conexao.php";
    
    // Sanitiza o ID para evitar problemas de segurança
    $codigo = intval($_GET["id"]);

    // Cria o comando SQL para excluir o projeto
    $sql = "DELETE FROM projetos WHERE id = $codigo";

    // Executa o comando SQL
    if (mysqli_query($mysqli, $sql)) {
        // Redireciona de volta para a página com a lista de projetos, indicando sucesso
        header("Location: paginaAdicionados.php?excluir=1");
    } else {
        // Em caso de erro, redireciona com uma mensagem de erro
        header("Location: paginaAdicionados.php?excluir=0");
    }
 
    // Fecha a conexão com o banco de dados
    mysqli_close($mysqli);
} else {
    // Redireciona de volta se o ID não foi fornecido
    header("Location: paginaAdicionados.php?erro=id_nao_informado");
}
?>
