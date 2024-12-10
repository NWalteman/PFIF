<?php

// Inclui a conexão com o banco de dados
require "../global_php/conexao.php";

// Obtém o ID do projeto via GET
$project_id = $_GET['id'] ?? 1; // Caso o ID não seja passado na URL, o valor padrão será 1.
$sql = "SELECT * FROM projetos WHERE id = ?"; // SQL para selecionar todos os dados de um projeto com o ID fornecido.
$stmt = $mysqli->prepare($sql); // Prepara a consulta SQL.
$stmt->bind_param("i", $project_id); // Liga o parâmetro 'id' ao tipo inteiro, para prevenir injeção de SQL.
$stmt->execute(); // Executa a consulta SQL.
$result = $stmt->get_result(); // Obtém o resultado da consulta.


// Verifica se o projeto existe
if ($result->num_rows > 0) {
    $project = $result->fetch_assoc(); // Se o projeto for encontrado, pega os dados do projeto.
} else {
    echo "Projeto não encontrado."; // Caso não encontre o projeto, exibe uma mensagem de erro.
    exit; // Encerra o script.
}

// Define o caminho do arquivo baseado no ID do projeto
$pasta_arquivos = __DIR__ . "/../arquivos/"; // Caminho da pasta onde os arquivos estão armazenados.
$arquivo_projeto = $pasta_arquivos . "projeto_{$project_id}.pdf"; // Define o nome do arquivo com base no ID do projeto.

// Verifica se o arquivo existe
if (file_exists($arquivo_projeto)) {
    $caminho_arquivo = "../arquivos/projeto_{$project_id}.pdf"; // Se o arquivo existir, define o caminho completo do arquivo.
} else {
    $caminho_arquivo = null; // Caso o arquivo não seja encontrado, define o caminho como null.
}

// Fecha a conexão com o banco de dados
$mysqli->close(); // Fecha a conexão com o banco de dados.

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8"> <!-- Define o conjunto de caracteres para UTF-8 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Torna a página responsiva -->
    <title>Informações do Projeto - PFIF</title> <!-- Título da página -->
    <link rel="stylesheet" href="../USER_css/projetoUSER.css"> <!-- Link para o arquivo de CSS -->
</head>

<body>
    <!-- Navbar -->
    <header>
        <div class="logo">
            <img src="../midia/logoNavbar.png" alt="Logo PFIF"> <!-- Exibe o logo na navbar -->
        </div>
        <nav>
            <a href="telaInicialUSER.php">Início</a> <!-- Link para a página inicial -->
        </nav>
        <div class="container-pesquisa">
            <!-- Formulário de pesquisa normal -->
            <form action="resultadoUSER.php" method="GET" id="form-pesquisa">
                <input type="text" name="consulta" placeholder="Pesquisar"> <!-- Campo de pesquisa -->
                <button type="submit">Pesquisar</button> <!-- Botão de envio do formulário -->
            </form>
            <button id="disparar-pesquisa-avancada">Pesquisa Avançada</button> <!-- Botão para disparar a pesquisa avançada -->
            <a class="sair" href="../global_html/paginaEntrar.html">Sair</a> <!-- Link para logout -->
        </div>
    </header>

    <!-- Pesquisa Avançada -->
    <div id="container-pesquisa-avancada">
        <form action="resultadoUSER.php" method="GET" id="form-pesquisa-avancada">
            <div>
                <label for="palavras-chave">Palavras-chave:</label>
                <input type="text" id="palavras-chave" name="palavras-chave" placeholder="Digite as palavras-chave"> <!-- Campo de pesquisa por palavras-chave -->
            </div>
            <div>
                <label for="data-inicial">Data inicial:</label>
                <input type="date" id="data-inicial" name="data_inicial"> <!-- Campo para selecionar a data inicial -->
            </div>
            <div>
                <label for="data-final">Data final:</label>
                <input type="date" id="data-final" name="data_final"> <!-- Campo para selecionar a data final -->
            </div>
            <div>
                <label for="tipo-plataforma">Tipo de Plataforma:</label>
                <select id="tipo-plataforma" name="tipo_plataforma">
                    <option value="">Selecione</option> <!-- Opção de seleção do tipo de plataforma -->
                    <option value="web">Web</option>
                    <option value="mobile">Mobile</option>
                    <option value="desktop">Desktop</option>
                </select>
            </div>
            <button type="submit">Pesquisar</button> <!-- Botão de envio da pesquisa avançada -->
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
        <p><span>Número de Páginas do Artigo:</span> <?php echo htmlspecialchars($project['num_paginas']); ?></p> <!-- Exibe o número de páginas do artigo -->
        <p><span>Resumo do Projeto:</span> <?php echo htmlspecialchars($project['resumo']); ?></p> <!-- Exibe o resumo do projeto -->
        <p><span>Observações:</span> <?php echo htmlspecialchars($project['observacoes']); ?></p> <!-- Exibe as observações -->
        
        <?php if ($caminho_arquivo): ?>
            <a href="<?php echo htmlspecialchars($caminho_arquivo); ?>" class="download-button" download>Baixar Artigo Completo</a> <!-- Link para download do arquivo PDF -->
        <?php else: ?>
            <p><em>Arquivo do artigo não encontrado.</em></p> <!-- Mensagem caso o arquivo não seja encontrado -->
        <?php endif; ?>
    </div>

    <!-- Script para alternar a exibição da pesquisa avançada -->
    <script>
        // Alterna a exibição da pesquisa avançada
        document.getElementById('disparar-pesquisa-avancada').addEventListener('click', function () {
            const pesquisaAvancada = document.getElementById('container-pesquisa-avancada');
            pesquisaAvancada.style.display = pesquisaAvancada.style.display === 'block' ? 'none' : 'block'; // Alterna entre exibir ou ocultar a pesquisa avançada
        });
    </script>
</body>

</html>
