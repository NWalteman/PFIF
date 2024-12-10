<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8"> <!-- Define a codificação de caracteres como UTF-8 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Torna a página responsiva para dispositivos móveis -->
    <title>Informativo - PFIF</title> <!-- Título da página -->
    <link rel="stylesheet" href="../USER_css/inicialUSER.css"> <!-- Link para o arquivo de estilo CSS -->
</head>

<body>

    <!-- Barra de Navegação (Navbar) -->
    <header>
        <div class="logo">
            <img src="../midia/logoNavbar.png" alt="Logo PFIF"> <!-- Exibe o logo da plataforma PFIF -->
        </div>
        <nav>
            <a href="telaInicialUSER.php">Início</a> <!-- Link para a página inicial -->
        </nav>
        <div class="container-pesquisa">
            <!-- Formulário de Pesquisa Normal -->
            <form action="resultadoUSER.php" method="GET" id="form-pesquisa">
                <input type="text" name="consulta" placeholder="Pesquisar"> <!-- Campo de pesquisa -->
                <button type="submit">Pesquisar</button> <!-- Botão para submeter a pesquisa -->
            </form>
            <button id="disparar-pesquisa-avancada">Pesquisa Avançada</button> <!-- Botão para exibir a pesquisa avançada -->
            <a class="sair" href="../global_html/paginaEntrar.html">Sair</a> <!-- Link para sair (logout) -->
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
                <select id="tipo-plataforma" name="tipo_plataforma"> <!-- Campo para escolher o tipo de plataforma -->
                    <option value="">Selecione</option> <!-- Opção padrão -->
                    <option value="web">Web</option>
                    <option value="mobile">Mobile</option>
                    <option value="desktop">Desktop</option>
                </select>
            </div>
            <button type="submit">Pesquisar</button> <!-- Botão para submeter a pesquisa avançada -->
        </form>
    </div>

    <!-- Conteúdo Informativo -->
    <div class="container">
        <h2>O que é o PFIF?</h2>
        <p>O PFIF é uma plataforma WEB de gerenciamento dos PFIs do IFPR câmpus avançado Quedas do Iguaçu. Nele, você pode consultar os PFIs dos estudantes do câmpus, tendo acesso a várias informações importantes relacionadas ao PFI.</p>

        <h2>Como funciona o PFIF?</h2>
        <p>É muito simples, você pode começar pesquisando utilizando a pesquisa simples ou a avançada. Com isso, você poderá acessar os detalhes do projeto clicando em cima do resultado que obtiver após a pesquisa. É possível realizar o logout clicando no botão “Sair” no canto superior direito. </p>

        <h2>Mas... o que é o PFI? </h2>
        <p>Segundo o Projeto Pedagógico do Curso Técnico em Informática Integrado ao Ensino Médio do Instituto Federal do Paraná (IFPR) câmpus avançado Quedas do Iguaçu, o Projeto Final Interdisciplinar (PFI) é uma etapa curricular obrigatória para os estudantes do Curso Técnico em Informática Integrado ao Ensino Médio do IFPR câmpus avançado Quedas do Iguaçu, a qual apresenta algumas semelhanças ao Trabalho de Conclusão de Curso (TCC) comumente empregado no Ensino Superior. Tem o objetivo de consolidar e aplicar os conhecimentos adquiridos ao longo da formação (seja esse conhecimento relacionado ao Curso ou à base do Ensino Médio), através da realização de um projeto prático e abrangente. Especificamente, os estudantes devem desenvolver um projeto formal escrito, um artigo científico e uma aplicação tecnológica (ex.: plataformas desktop, WEB, mobile ou hardwares).</p>

        <h2>Quem criou o PFIF?</h2>
        <p>Um egresso do Curso Técnico em Informática Integrado ao Ensino Médio do IFPR câmpus avançado Quedas do Iguaçu, Nicollas Rau Walteman Fausto. Esse sistema foi produzido para o PFI desse estudante. Além disso, ele utilizou as tecnologias estudadas ao longo dos 3 anos de formação dos estudantes do Curso Técnico em Informática do câmpus avançado Quedas do Iguaçu.</p>

    </div>

    <!-- Script para alternar a exibição da pesquisa avançada -->
    <script>
        document.getElementById('disparar-pesquisa-avancada').addEventListener('click', function () {
            const pesquisaAvancada = document.getElementById('container-pesquisa-avancada');
            // Alterna a visibilidade do formulário de pesquisa avançada
            pesquisaAvancada.style.display = pesquisaAvancada.style.display === 'block' ? 'none' : 'block';
        });
    </script>

</body>

</html>
