<?php

require 'verifica_sessao.php'; // Verifica a sessão do usuário

// Inclui a conexão com o banco de dados
require "../global_php/conexao.php";

// Obtém o ID do projeto via GET
$project_id = $_GET['id'] ?? 1; // Default para 1 caso nenhum ID seja passado
$sql = "SELECT * FROM projetos WHERE id = ?"; // Prepara a consulta SQL para buscar o projeto pelo ID
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $project_id); // Faz o bind do parâmetro $project_id para a consulta
$stmt->execute(); // Executa a consulta
$result = $stmt->get_result(); // Obtém o resultado da consulta

// Verifica se o projeto existe
if ($result->num_rows > 0) {
    $project = $result->fetch_assoc(); // Se o projeto for encontrado, armazena os dados
} else {
    echo "Projeto não encontrado."; // Se o projeto não for encontrado, exibe mensagem e encerra a execução
    exit;
}

// Define o caminho do arquivo baseado no ID do projeto
$pasta_arquivos = __DIR__ . "/../arquivos/"; // Caminho para a pasta de arquivos
$arquivo_projeto = $pasta_arquivos . "projeto_{$project_id}.pdf"; // Nome do arquivo PDF do projeto

// Verifica se o arquivo existe
if (file_exists($arquivo_projeto)) {
    $caminho_arquivo = "../arquivos/projeto_{$project_id}.pdf"; // Se o arquivo existe, define o caminho
} else {
    $caminho_arquivo = null; // Se o arquivo não existe, define como null
}

// Fecha a conexão com o banco de dados
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8"> <!-- Define o charset como UTF-8 para garantir que caracteres acentuados sejam exibidos corretamente -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Garante que a página seja responsiva em dispositivos móveis -->
    <title>Informações do Projeto - PFIF</title> <!-- Título da página -->
    <link rel="stylesheet" href="../ADM_css/projetoADM.css"> <!-- Vincula o arquivo CSS para estilizar o layout -->
</head>

<body>
    <!-- Navbar -->
    <header>
        <div class="logo">
            <img src="../midia/logoNavbar.png" alt="Logo PFIF"> <!-- Exibe o logo da plataforma -->
        </div>
        <nav>
            <a href="paginaInicial.php">Início</a> <!-- Link para a página inicial -->
            <a href="paginaAdicionados.php">Adicionados</a> <!-- Link para a página de projetos adicionados -->
            <a href="paginaAdicionar.php">Adicionar</a> <!-- Link para a página de adicionar projetos -->
        </nav>
        <div class="container-pesquisa">
            <!-- Formulário de Pesquisa -->
            <form action="resultado.php" method="GET" id="form-pesquisa">
                <input type="text" name="consulta" placeholder="Pesquisar"> <!-- Campo de pesquisa -->
                <button type="submit">Pesquisar</button> <!-- Botão para submeter a pesquisa -->
            </form>
            <button id="disparar-pesquisa-avancada">Pesquisa Avançada</button> <!-- Botão para disparar a pesquisa avançada -->
            <a class="sair" href="logout.php">Sair</a> <!-- Link para sair da sessão -->
        </div>
    </header>

    <!-- Pesquisa Avançada -->
    <div id="container-pesquisa-avancada">
        <form action="resultado.php" method="GET" id="form-pesquisa-avancada">
            <div>
                <label for="palavras-chave">Palavras-chave:</label>
                <input type="text" id="palavras-chave" name="palavras-chave" placeholder="Digite as palavras-chave">
            </div>
            <div>
                <label for="data-inicial">Data inicial:</label>
                <input type="date" id="data-inicial" name="data_inicial">
            </div>
            <div>
                <label for="data-final">Data final:</label>
                <input type="date" id="data-final" name="data_final">
            </div>
            <div>
                <label for="tipo-plataforma">Tipo de Plataforma:</label>
                <select id="tipo-plataforma" name="tipo_plataforma">
                    <option value="">Selecione</option>
                    <option value="web">Web</option>
                    <option value="mobile">Mobile</option>
                    <option value="desktop">Desktop</option>
                </select>
            </div>
            <button type="submit">Pesquisar</button>
        </form>
    </div>

    <!-- Conteúdo Informativo do Projeto -->
    <div class="container project-info">
        <h2>Título do Projeto: <?php echo htmlspecialchars($project['titulo']); ?></h2> <!-- Exibe o título do projeto -->
        <p><span>Estudante:</span> <?php echo htmlspecialchars($project['nome_estudante']); ?></p> <!-- Exibe o nome do estudante -->
        <p><span>Orientador:</span> <?php echo htmlspecialchars($project['orientador']); ?></p> <!-- Exibe o nome do orientador -->
        <p><span>Coorientador:</span> <?php echo htmlspecialchars($project['coorientador']); ?></p> <!-- Exibe o nome do coorientador -->
        <p><span>Data de Publicação:</span> <?php echo htmlspecialchars($project['data_publicacao']); ?></p> <!-- Exibe a data de publicação -->
        <p><span>Palavras-chave:</span> <?php echo htmlspecialchars($project['palavras_chave']); ?></p> <!-- Exibe as palavras-chave -->
        <p><span>Membros da Banca:</span> <?php echo htmlspecialchars($project['membros_banca']); ?></p> <!-- Exibe os membros da banca -->
        <p><span>Tema:</span> <?php echo htmlspecialchars($project['tema']); ?></p> <!-- Exibe o tema do projeto -->
        <p><span>Tipo de plataforma:</span> <?php echo htmlspecialchars($project['tipo_plataforma']); ?></p> <!-- Exibe o tipo de plataforma -->
        <p><span>Número de Páginas do Artigo:</span> <?php echo htmlspecialchars($project['num_paginas']); ?></p> <!-- Exibe o número de páginas -->
        <p><span>Resumo do Projeto:</span> <?php echo htmlspecialchars($project['resumo']); ?></p> <!-- Exibe o resumo do projeto -->
        <p><span>Observações:</span> <?php echo htmlspecialchars($project['observacoes']); ?></p> <!-- Exibe observações do projeto -->

        <!-- Link para download do artigo, se o arquivo existir -->
        <?php if ($caminho_arquivo): ?>
            <a href="<?php echo htmlspecialchars($caminho_arquivo); ?>" class="download-button" download>Baixar Artigo Completo</a>
        <?php else: ?>
            <p><em>Arquivo do artigo não encontrado.</em></p> <!-- Mensagem caso o arquivo não seja encontrado -->
        <?php endif; ?>
    </div>

    <!-- Script para alternar a exibição da pesquisa avançada -->
    <script>
        // Alterna a exibição da pesquisa avançada
        document.getElementById('disparar-pesquisa-avancada').addEventListener('click', function () {
            const pesquisaAvancada = document.getElementById('container-pesquisa-avancada');
            pesquisaAvancada.style.display = pesquisaAvancada.style.display === 'block' ? 'none' : 'block';
        });
    </script>
</body>

</html>
