<?php

require 'verifica_sessao.php'; // Inclui o arquivo de verificação de sessão
require_once "../global_php/conexao.php";

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query = "SELECT * FROM projetos WHERE id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $projeto = $result->fetch_assoc();
    } else {
        echo "Projeto não encontrado.";
        exit;
    }
} else {
    echo "ID inválido.";
    exit;
}

if (isset($_POST["submit"])) {
    $titulo = $_POST["titulo"];
    $nome_estudante = $_POST["nome_estudante"];
    $orientador = $_POST["orientador"];
    $coorientador = $_POST["coorientador"];
    $data_publicacao = $_POST["data_publicacao"];
    $palavras_chave = $_POST["palavras_chave"];
    $membros_banca = $_POST["membros_banca"];
    $tema = $_POST["tema"];
    $num_paginas = $_POST["num_paginas"];
    $resumo = $_POST["resumo"];
    $observacoes = $_POST["observacoes"];

    // Atualizar os dados no banco de dados
    $update_query = "UPDATE projetos SET titulo = ?, nome_estudante = ?, orientador = ?, coorientador = ?, data_publicacao = ?, palavras_chave = ?, membros_banca = ?, tema = ?, num_paginas = ?, resumo = ?, observacoes = ? WHERE id = ?";
    $stmt = $mysqli->prepare($update_query);
    $stmt->bind_param(
        "sssssssssssi",
        $titulo,
        $nome_estudante,
        $orientador,
        $coorientador,
        $data_publicacao,
        $palavras_chave,
        $membros_banca,
        $tema,
        $num_paginas,
        $resumo,
        $observacoes,
        $id
    );

    if ($stmt->execute()) {
        // Lidar com upload de arquivo
        if (isset($_FILES['arquivo_artigo']) && $_FILES['arquivo_artigo']['error'] == UPLOAD_ERR_OK) {
            $pasta = "../arquivos/";
            $nome_original = $_FILES['arquivo_artigo']['name'];
            $extensao = pathinfo($nome_original, PATHINFO_EXTENSION);
            $nome_final = "projeto_" . $id . "." . $extensao;
            $caminho_final = $pasta . $nome_final;

            if (move_uploaded_file($_FILES['arquivo_artigo']['tmp_name'], $caminho_final)) {
            } else {
            }
        }

    } else {
        echo "Erro ao atualizar o projeto: " . $stmt->error;
    }

    $stmt->close();
}
?>


<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Projeto - PFIF</title>
    <link rel="stylesheet" href="../ADM_css/editar.css">
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
            <!-- Pesquisa Normal -->
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

    <div class="container">
        <h2>Editar Projeto</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="titulo">Título</label>
                <input type="text" id="titulo" name="titulo" value="<?php echo htmlspecialchars($projeto['titulo']); ?>" required>
            </div>
            <div class="form-group">
                <label for="nome_estudante">Nome do Estudante</label>
                <input type="text" id="nome_estudante" name="nome_estudante" value="<?php echo htmlspecialchars($projeto['nome_estudante']); ?>" required>
            </div>
            <div class="form-group">
                <label for="orientador">Orientador</label>
                <input type="text" id="orientador" name="orientador" value="<?php echo htmlspecialchars($projeto['orientador']); ?>" required>
            </div>
            <div class="form-group">
                <label for="coorientador">Coorientador</label>
                <input type="text" id="coorientador" name="coorientador" value="<?php echo htmlspecialchars($projeto['coorientador']); ?>">
            </div>
            <div class="form-group">
                <label for="data_publicacao">Data de Publicação</label>
                <input type="date" id="data_publicacao" name="data_publicacao" value="<?php echo htmlspecialchars($projeto['data_publicacao']); ?>" required>
            </div>
            <div class="form-group">
                <label for="palavras_chave">Palavras-chave</label>
                <input type="text" id="palavras_chave" name="palavras_chave" value="<?php echo htmlspecialchars($projeto['palavras_chave']); ?>">
            </div>
            <div class="form-group">
                <label for="membros_banca">Membros da Banca</label>
                <input type="text" id="membros_banca" name="membros_banca" value="<?php echo htmlspecialchars($projeto['membros_banca']); ?>">
            </div>
            <div class="form-group">
                <label for="tema">Tema</label>
                <input type="text" id="tema" name="tema" value="<?php echo htmlspecialchars($projeto['tema']); ?>">
            </div>
            <div class="form-group">
                <label for="num_paginas">Número de Páginas</label>
                <input type="text" id="num_paginas" name="num_paginas" value="<?php echo htmlspecialchars($projeto['num_paginas']); ?>">
            </div>
            <div class="form-group">
                <label for="resumo">Resumo</label>
                <textarea id="resumo" name="resumo"><?php echo htmlspecialchars($projeto['resumo']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="observacoes">Observações</label>
                <textarea id="observacoes" name="observacoes"><?php echo htmlspecialchars($projeto['observacoes']); ?></textarea>
            </div>
            <div class="form-group upload-container">
                <label for="arquivo_artigo">Atualizar arquivo do artigo</label>
                <input type="file" id="arquivo_artigo" name="arquivo_artigo">
            </div>

            <div class="buttons">
                <button type="submit" name="submit" class="postar">Atualizar</button>
                <button type="reset" class="limpar">Limpar</button>
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
