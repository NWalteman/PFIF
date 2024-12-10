<?php

require 'verifica_sessao.php'; // Inclui o arquivo de verificação de sessão

// Inclui a conexão com o banco de dados
include"../global_php/conexao.php";

// Captura os dados da pesquisa simples ou avançada
$consulta = isset($_GET['consulta']) ? $_GET['consulta'] : '';
$palavras_chave = isset($_GET['palavras-chave']) ? $_GET['palavras-chave'] : '';
$data_inicial = isset($_GET['data_inicial']) ? $_GET['data_inicial'] : '';
$data_final = isset($_GET['data_final']) ? $_GET['data_final'] : '';
$tipo_plataforma = isset($_GET['tipo_plataforma']) ? $_GET['tipo_plataforma'] : '';

// Prepara a consulta SQL
$sql = "SELECT * FROM projetos WHERE 1=1";

// Se a pesquisa simples for usada, adiciona o filtro
if (!empty($consulta)) {
    $sql .= " AND (titulo LIKE '%$consulta%' OR resumo LIKE '%$consulta%')";
}

// Se a pesquisa avançada for usada, adiciona os filtros adicionais
if (!empty($palavras_chave)) {
    $sql .= " AND palavras_chave LIKE '%$palavras_chave%'";
}

if (!empty($data_inicial)) {
    $sql .= " AND data_publicacao >= '$data_inicial'";
}

if (!empty($data_final)) {
    $sql .= " AND data_publicacao <= '$data_final'";
}

if (!empty($tipo_plataforma)) {
    $sql .= " AND tipo_plataforma = '$tipo_plataforma'";
}

// Executa a consulta
$resultado = mysqli_query($mysqli, $sql);

// Fecha a conexão com o banco de dados
mysqli_close($mysqli);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados - PFIF</title>
    <link rel="stylesheet" href="../ADM_css/resultadoADM.css">

</head>

<body>
    <!-- Navbar -->
    <header>
        <div class="logo">
        <img src="../midia/logoNavbar.png" alt="Logo PFIF">
        </div>
        <nav>
            <a href="paginaInicial.php">Início</a>
            <a href="paginaAdicionados.php">Adicionados</a>
            <a href="paginaAdicionar.php">Adicionar</a>
        </nav>
        <div class="container-pesquisa">
            <form action="resultado.php" method="GET" id="form-pesquisa">
                <input type="text" name="consulta" placeholder="Pesquisar">
                <button type="submit">Pesquisar</button>
            </form>
            <button id="disparar-pesquisa-avancada">Pesquisa Avançada</button>
            <a class="sair" href="logout.php">Sair</a>
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

    <div class="resultados">
        <h2>Resultados da Pesquisa</h2>

        <?php
        if (mysqli_num_rows($resultado) > 0) {
            while ($projeto = mysqli_fetch_assoc($resultado)) {
                echo "<div class='projeto'>";
                // Link clicável para a página do projeto, passando o ID
                echo "<a href='paginaProjeto.php?id=" . htmlspecialchars($projeto['id']) . "'>";
                echo "<h3>" . htmlspecialchars($projeto['titulo']) . "</h3>";
                echo "</a>";
                // Exibindo detalhes do projeto
                echo "<p><strong>Estudante:</strong> " . htmlspecialchars($projeto['nome_estudante']) . "</p>";
                echo "<p><strong>Orientador:</strong> " . htmlspecialchars($projeto['orientador']) . "</p>";
                echo "<p><strong>Data de Publicação:</strong> " . htmlspecialchars($projeto['data_publicacao']) . "</p>";
                echo "<p><strong>Resumo:</strong> " . htmlspecialchars(substr($projeto['resumo'], 0, 100)) . "...</p>"; // Resumo limitado a 100 caracteres
                echo "</div>";
            }
        } else {
            echo "<div class='nenhum-resultado'>Nenhum projeto encontrado para sua pesquisa.</div>";
        }
        ?>
    </div>

    <script>
        // Exibir a pesquisa avançada quando o botão for clicado
        document.getElementById("disparar-pesquisa-avancada").addEventListener("click", function () {
            var container = document.getElementById("container-pesquisa-avancada");
            container.style.display = container.style.display === "none" ? "block" : "none";
        });
    </script>
</body>

</html>
