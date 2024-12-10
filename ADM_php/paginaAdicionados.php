<?php

require 'verifica_sessao.php'; // Inclui o arquivo de verificação de sessão

require_once "../global_php/conexao.php"; // Inclui o arquivo de conexão com o banco de dados

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8"> <!-- Define o charset como UTF-8, para suportar caracteres acentuados -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Ajusta a visualização para dispositivos móveis -->
    <title>Adicionados - PFIF</title> <!-- Título da página -->
    <link rel="stylesheet" href="../ADM_css/adicionados.css"> <!-- Vincula o arquivo de estilo CSS -->
</head>

<body>

    <!-- Navbar -->
    <header>
        <div class="logo">
            <img src="../midia/logoNavbar.png" alt="Logo PFIF"> <!-- Exibe o logotipo da plataforma -->
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
                <input type="text" name="consulta" placeholder="Pesquisar"> <!-- Campo de texto para pesquisa -->
                <button type="submit">Pesquisar</button> <!-- Botão para enviar a pesquisa -->
            </form>
            <button id="disparar-pesquisa-avancada">Pesquisa Avançada</button> <!-- Botão para abrir a pesquisa avançada -->
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
                <input type="date" id="data-inicial" name="data_inicial"> <!-- Campo para selecionar data inicial -->
            </div>
            <div>
                <label for="data-final">Data final:</label>
                <input type="date" id="data-final" name="data_final"> <!-- Campo para selecionar data final -->
            </div>
            <div>
                <label for="tipo-plataforma">Tipo de Plataforma:</label>
                <select id="tipo-plataforma" name="tipo_plataforma">
                    <option value="">Selecione</option>
                    <option value="web">Web</option>
                    <option value="mobile">Mobile</option>
                    <option value="desktop">Desktop</option> <!-- Opções para selecionar o tipo de plataforma -->
                </select>
            </div>
            <button type="submit">Pesquisar</button> <!-- Botão para enviar a pesquisa avançada -->
        </form>
    </div>

    <script>
        // Função para excluir um projeto
        function excluir(id) {
            if (confirm("Tem certeza de que deseja excluir este projeto?")) { // Confirmação antes de excluir
                location.href = "excluir.php?id=" + id; // Redireciona para a página de exclusão com o ID do projeto
            }
        }

        // Função para editar um projeto
        function editar(id) {
            location.href = "editar_projeto.php?id=" + id; // Redireciona para a página de edição com o ID do projeto
        }
    </script>

    <!-- Container com lista de projetos -->
    <div class="container">
        <h2>Projetos Adicionados</h2> <!-- Título da seção -->
        <ul class="project-list">
            <?php
            $sql = "SELECT id, titulo FROM projetos ORDER BY titulo"; // Consulta SQL para obter os projetos
            $result = mysqli_query($mysqli, $sql); // Executa a consulta no banco de dados

            // Verifica se a consulta retornou algum resultado
            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) { // Para cada projeto retornado
                    echo "<li>";
                    echo "<span>" . htmlspecialchars($row['titulo']) . "</span>"; // Exibe o título do projeto
                    echo "<div>";
                    echo "<button class='delete-btn' onclick='excluir(" . $row['id'] . ")'>APAGAR</button>"; // Botão para excluir o projeto
                    echo "<button class='edit-btn' onclick='editar(" . $row['id'] . ")'>EDITAR</button>"; // Botão para editar o projeto
                    echo "</div>";
                    echo "</li>";
                }
            } else {
                echo "<p>Nenhum projeto encontrado.</p>"; // Exibe mensagem caso não haja projetos
            }

            mysqli_free_result($result); // Libera os resultados da consulta
            ?>
        </ul>
    </div>

    <script>
        // Alterna a exibição da pesquisa avançada
        document.getElementById('disparar-pesquisa-avancada').addEventListener('click', function () {
            const pesquisaAvancada = document.getElementById('container-pesquisa-avancada');
            pesquisaAvancada.style.display = pesquisaAvancada.style.display === 'block' ? 'none' : 'block'; // Alterna a visibilidade do formulário
        });
    </script>

</body>

</html>
