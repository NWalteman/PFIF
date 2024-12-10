<?php

require 'verifica_sessao.php'; // Inclui o arquivo de verificação de sessão para garantir que o usuário esteja autenticado

if (isset($_POST["submit"])) { // Verifica se o formulário foi submetido
    include_once "../global_php/conexao.php"; // Inclui o arquivo de conexão com o banco de dados

    // Coleta os dados do formulário
    $titulo = $_POST["titulo"];
    $nome_estudante = $_POST["nome_estudante"];
    $orientador = $_POST["orientador"];
    $coorientador = $_POST["coorientador"];
    $data_publicacao = $_POST["data_publicacao"];
    $palavras_chave = $_POST["palavras_chave"];
    $membros_banca = $_POST["membros_banca"];
    $tema = $_POST["tema"];
    $tipo_plataforma = $_POST["tipo_plataforma"];
    $num_paginas = $_POST["num_paginas"];
    $resumo = $_POST["resumo"];
    $observacoes = $_POST["observacoes"];

    // Inserir dados no banco de dados com prepared statements para evitar SQL Injection
    $query = "INSERT INTO projetos (titulo, nome_estudante, orientador, coorientador, data_publicacao, palavras_chave, membros_banca, tema, tipo_plataforma, num_paginas, resumo, observacoes) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($query); // Prepara a consulta
    $stmt->bind_param(
        "ssssssssisss", // Define o tipo de cada parâmetro (s = string, i = inteiro)
        $titulo, 
        $nome_estudante, 
        $orientador, 
        $coorientador, 
        $data_publicacao, 
        $palavras_chave, 
        $membros_banca, 
        $tema, 
        $tipo_plataforma,
        $num_paginas, 
        $resumo, 
        $observacoes
    );

    if ($stmt->execute()) { // Executa a consulta no banco de dados
        // Obtém o ID do último registro inserido
        $id = $stmt->insert_id;

        // Lidar com upload de arquivo
        if (isset($_FILES['arquivo_artigo']) && $_FILES['arquivo_artigo']['error'] == UPLOAD_ERR_OK) { // Verifica se o arquivo foi enviado e não houve erro
            $pasta = "../arquivos/"; // Caminho da pasta onde o arquivo será armazenado
            $nome_original = $_FILES['arquivo_artigo']['name']; // Obtém o nome original do arquivo
            $extensao = pathinfo($nome_original, PATHINFO_EXTENSION); // Obtém a extensão do arquivo
            $nome_final = "projeto_" . $id . "." . $extensao; // Nome final do arquivo (com ID do projeto)
            $caminho_final = $pasta . $nome_final; // Caminho completo para salvar o arquivo

            if (move_uploaded_file($_FILES['arquivo_artigo']['tmp_name'], $caminho_final)) { // Move o arquivo para o diretório final
            } else {
                echo "Erro ao salvar o arquivo."; // Exibe mensagem de erro
            }
        } else {
            echo "Nenhum arquivo foi enviado ou ocorreu um erro no upload."; // Mensagem caso não haja arquivo ou erro no upload
        }

    } else {
        echo "Erro ao adicionar o projeto: " . $stmt->error; // Mensagem de erro caso a inserção falhe
    }

    $stmt->close(); // Fecha a declaração SQL
    $mysqli->close(); // Fecha a conexão com o banco de dados
}
?> 

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8"> <!-- Define o charset como UTF-8 para suportar caracteres acentuados -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Ajusta a visualização da página para dispositivos móveis -->
    <title>Adicionar Projeto - PFIF</title> <!-- Título da página -->
    <link rel="stylesheet" href="../ADM_css/adicionar.css"> <!-- Vincula o arquivo CSS da página de adicionar projeto -->
</head>

<body>

    <!-- Navbar -->
    <header>
        <div class="logo">
            <img src="../midia/logoNavbar.png" alt="Logo PFIF"> <!-- Exibe o logo da plataforma -->
        </div>
        <nav>
            <!-- Links de navegação para outras páginas -->
            <a href="paginaInicial.php">Início</a>
            <a href="paginaAdicionados.php">Adicionados</a>
            <a href="paginaAdicionar.php">Adicionar</a>
        </nav>
        <div class="container-pesquisa">
            <!-- Formulário de pesquisa -->
            <form action="resultado.php" method="GET" id="form-pesquisa">
                <input type="text" name="consulta" placeholder="Pesquisar"> <!-- Campo de pesquisa -->
                <button type="submit">Pesquisar</button> <!-- Botão para realizar a pesquisa -->
            </form>
            <button id="disparar-pesquisa-avancada">Pesquisa Avançada</button> <!-- Botão para abrir pesquisa avançada -->
            <a class="sair" href="logout.php">Sair</a> <!-- Link para sair da plataforma -->
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
                <input type="date" id="data-inicial" name="data_inicial"> <!-- Campo de data inicial -->
            </div>
            <div>
                <label for="data-final">Data final:</label>
                <input type="date" id="data-final" name="data_final"> <!-- Campo de data final -->
            </div>
            <div>
                <label for="tipo-plataforma">Tipo de Plataforma:</label>
                <select id="tipo-plataforma" name="tipo_plataforma"> <!-- Dropdown para selecionar o tipo de plataforma -->
                    <option value="">Selecione</option>
                    <option value="web">Web</option>
                    <option value="mobile">Mobile</option>
                    <option value="desktop">Desktop</option>
                </select>
            </div>
            <button type="submit">Pesquisar</button> <!-- Botão para submeter a pesquisa -->
        </form>
    </div>

    <!-- Formulário de Adicionar Projeto -->
    <div class="container">
        <h2>Adicionar Projeto</h2> <!-- Título do formulário -->
        <form action="paginaAdicionar.php" method="post" enctype="multipart/form-data">
            <!-- Campos do formulário para inserir os dados do projeto -->
            <div class="form-group">
                <label for="titulo">Título do projeto</label>
                <input type="text" id="titulo" name="titulo">
            </div>

            <div class="form-group">
                <label for="nome_estudante">Estudante</label>
                <input type="text" id="nome_estudante" name="nome_estudante">
            </div>

            <div class="form-group">
                <label for="orientador">Orientador</label>
                <input type="text" id="orientador" name="orientador">
            </div>

            <div class="form-group">
                <label for="coorientador">Coorientador</label>
                <input type="text" id="coorientador" name="coorientador">
            </div>

            <div class="form-group">
                <label for="data_publicacao">Data de publicação</label>
                <input type="date" id="data_publicacao" name="data_publicacao">
            </div>

            <div class="form-group">
                <label for="palavras_chave">Palavras-chave</label>
                <input type="text" id="palavras_chave" name="palavras_chave">
            </div>

            <div class="form-group">
                <label for="membros_banca">Membros da banca</label>
                <input type="text" id="membros_banca" name="membros_banca">
            </div>

            <div class="form-group">
                <label for="tema">Tema</label>
                <input type="text" id="tema" name="tema">
            </div>

            <div class="form-group">
                <label for="tipo_plataforma">Tipo de plataforma</label>
                <input type="text" id="tipo_plataforma" name="tipo_plataforma">
            </div>

            <div class="form-group">
                <label for="num_paginas">Número de páginas do artigo</label>
                <input type="text" id="num_paginas" name="num_paginas">
            </div>

            <div class="form-group">
                <label for="resumo">Resumo do projeto (até xxx caracteres)</label>
                <textarea id="resumo" name="resumo"></textarea>
            </div>

            <div class="form-group">
                <label for="observacoes">Observações</label>
                <textarea id="observacoes" name="observacoes"></textarea>
            </div>

            <div class="form-group upload-container">
                <label for="arquivo_artigo">Fazer upload do artigo</label>
                <input type="file" id="arquivo_artigo" name="arquivo_artigo"> <!-- Campo para upload do arquivo -->
            </div>

            <div class="buttons">
                <button class="limpar" type="reset">Limpar</button> <!-- Botão para limpar o formulário -->
                <input type="submit" name="submit" id="submit"> <!-- Botão para submeter o formulário -->
            </div>
        </form>
    </div>

    <script>
        // Alterna a exibição da pesquisa avançada
        document.getElementById('disparar-pesquisa-avancada').addEventListener('click', function () {
            const pesquisaAvancada = document.getElementById('container-pesquisa-avancada');
            pesquisaAvancada.style.display = pesquisaAvancada.style.display === 'block' ? 'none' : 'block';
        });
    </script>
</body>

</html>
