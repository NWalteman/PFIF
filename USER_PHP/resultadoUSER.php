<?php

// Inclui o arquivo de conexão com o banco de dados
include "../global_php/conexao.php";

// Captura os dados da pesquisa simples ou avançada via URL (GET)
$consulta = isset($_GET['consulta']) ? $_GET['consulta'] : ''; // Pesquisa simples
$palavras_chave = isset($_GET['palavras-chave']) ? $_GET['palavras-chave'] : ''; // Pesquisa por palavras-chave
$data_inicial = isset($_GET['data_inicial']) ? $_GET['data_inicial'] : ''; // Data inicial para o filtro
$data_final = isset($_GET['data_final']) ? $_GET['data_final'] : ''; // Data final para o filtro
$tipo_plataforma = isset($_GET['tipo_plataforma']) ? $_GET['tipo_plataforma'] : ''; // Tipo de plataforma

// Prepara a consulta SQL base, selecionando todos os projetos
$sql = "SELECT * FROM projetos WHERE 1=1"; // A condição "1=1" é usada para facilitar a adição de filtros

// Se a pesquisa simples foi realizada, adiciona o filtro para título e resumo
if (!empty($consulta)) {
    $sql .= " AND (titulo LIKE '%$consulta%' OR resumo LIKE '%$consulta%')";
}

// Se a pesquisa avançada for utilizada, adiciona os filtros adicionais
if (!empty($palavras_chave)) {
    $sql .= " AND palavras_chave LIKE '%$palavras_chave%'"; // Filtro por palavras-chave
}

if (!empty($data_inicial)) {
    $sql .= " AND data_publicacao >= '$data_inicial'"; // Filtro por data inicial
}

if (!empty($data_final)) {
    $sql .= " AND data_publicacao <= '$data_final'"; // Filtro por data final
}

if (!empty($tipo_plataforma)) {
    $sql .= " AND tipo_plataforma = '$tipo_plataforma'"; // Filtro por tipo de plataforma
}

// Executa a consulta SQL
$resultado = mysqli_query($mysqli, $sql);

// Fecha a conexão com o banco de dados após a execução da consulta
mysqli_close($mysqli);

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8"> <!-- Define a codificação de caracteres para UTF-8 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Torna a página responsiva -->
    <title>Resultados - PFIF</title> <!-- Título da página -->
    <link rel="stylesheet" href="../USER_css/resultadoUSER.css"> <!-- Link para o arquivo de estilo CSS -->

</head>

<body>
    <!-- Barra de Navegação -->
    <header>
        <div class="logo">
            <img src="../midia/logoNavbar.png" alt="Logo PFIF"> <!-- Exibe o logo na navbar -->
        </div>
        <nav>
            <a href="telaInicialUSER.php">Início</a> <!-- Link para a página inicial -->
        </nav>
        <div class="container-pesquisa">
            <!-- Formulário de Pesquisa Simples -->
            <form action="resultadoUSER.php" method="GET" id="form-pesquisa">
                <input type="text" name="consulta" placeholder="Pesquisar"> <!-- Campo de pesquisa -->
                <button type="submit">Pesquisar</button> <!-- Botão para enviar a pesquisa -->
            </form>
            <button id="disparar-pesquisa-avancada">Pesquisa Avançada</button> <!-- Botão para abrir a pesquisa avançada -->
            <a class="sair" href="../global_html/paginaEntrar.html">Sair</a> <!-- Link para logout -->
        </div>
    </header>

    <!-- Formulário de Pesquisa Avançada -->
    <div id="container-pesquisa-avancada">
        <form action="resultadoUSER.php" method="GET" id="form-pesquisa-avancada">
            <div>
                <label for="palavras-chave">Palavras-chave:</label>
                <input type="text" id="palavras-chave" name="palavras-chave" placeholder="Digite as palavras-chave"> <!-- Campo para palavras-chave -->
            </div>
            <div>
                <label for="data-inicial">Data inicial:</label>
                <input type="date" id="data-inicial" name="data_inicial"> <!-- Campo para data inicial -->
            </div>
            <div>
                <label for="data-final">Data final:</label>
                <input type="date" id="data-final" name="data_final"> <!-- Campo para data final -->
            </div>
            <div>
                <label for="tipo-plataforma">Tipo de Plataforma:</label>
                <select id="tipo-plataforma" name="tipo_plataforma">
                    <option value="">Selecione</option> <!-- Opção de tipo de plataforma -->
                    <option value="web">Web</option>
                    <option value="mobile">Mobile</option>
                    <option value="desktop">Desktop</option>
                </select>
            </div>
            <button type="submit">Pesquisar</button> <!-- Botão de envio da pesquisa avançada -->
        </form>
    </div>

    <!-- Exibição dos Resultados da Pesquisa -->
    <div class="resultados">
        <h2>Resultados da Pesquisa</h2>

        <?php
        // Verifica se há resultados para a pesquisa
        if (mysqli_num_rows($resultado) > 0) {
            // Itera sobre cada projeto encontrado na consulta
            while ($projeto = mysqli_fetch_assoc($resultado)) {
                echo "<div class='projeto'>"; // Início de cada projeto na lista
                // Link clicável para abrir a página do projeto com o ID
                echo "<a href='paginaProjetoUSER.php?id=" . htmlspecialchars($projeto['id']) . "'>";
                echo "<h3>" . htmlspecialchars($projeto['titulo']) . "</h3>"; // Exibe o título do projeto
                echo "</a>";
                // Exibe os detalhes do projeto
                echo "<p><strong>Estudante:</strong> " . htmlspecialchars($projeto['nome_estudante']) . "</p>";
                echo "<p><strong>Orientador:</strong> " . htmlspecialchars($projeto['orientador']) . "</p>";
                echo "<p><strong>Data de Publicação:</strong> " . htmlspecialchars($projeto['data_publicacao']) . "</p>";
                echo "<p><strong>Resumo:</strong> " . htmlspecialchars(substr($projeto['resumo'], 0, 100)) . "...</p>"; // Exibe um resumo limitado a 100 caracteres
                echo "</div>"; // Fim do bloco de cada projeto
            }
        } else {
            // Caso nenhum projeto seja encontrado, exibe a mensagem de erro
            echo "<div class='nenhum-resultado'>Nenhum projeto encontrado para sua pesquisa.</div>";
        }
        ?>
    </div>

    <script>
        // Script para exibir ou ocultar o formulário de pesquisa avançada
        document.getElementById("disparar-pesquisa-avancada").addEventListener("click", function () {
            var container = document.getElementById("container-pesquisa-avancada");
            // Alterna a exibição entre visível e invisível
            container.style.display = container.style.display === "none" ? "block" : "none";
        });
    </script>
</body>

</html>
