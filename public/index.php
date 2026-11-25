<?php
require "../service/FinancaService.php";
require "../service/CategoriaService.php";

session_start();
$financaService = new FinancaService();
$categoriaService = new CategoriaService();
$categorias = $categoriaService->getAll();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina Inicial</title>
    <link rel="stylesheet" href="resources/css/index.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="resources/js/financa.js" defer></script>
    <script src="resources/js/usuario.js" defer></script>
</head>
<body>
    <header>
        <div class="saldo">
                <span>Saldo atual</span>
                <h2 id="saldo"><?=$financaService->getSaldo();?></h2>
        </div>
        <div>
            <?= (isset($_SESSION["isAdmin"]) && $_SESSION["isAdmin"]) ? "<a href='admin.php' class='botao_admin'>Área Administrativa</a>" : ""?>
            <?= isset($_SESSION["idUsuario"]) ? "<a href='logout.php' class='botao_logout' id='logout'>Logout</a>" : "<a href='login.php' class='botao_entrar'>Entrar</a>"?>
        </div>
    </header>

    <section class="movimentacoes">
         <h2>Movimentações financeiras</h2>

         <div class="filtros">

            <select id="tipo">
                <option value="ALL">Todos</option>
                <option value="CREDITO">Créditos</option>
                <option value="DEBITO">Débitos</option>
            </select>

            <div class="filtro-periodo">
                <label for="data_inicio">De:</label>
                <input type="date" id="data_inicio">

                <label for="data_fim">Até:</label>
                <input type="date" id="data_fim">
            </div>

             <select id="categoria">
                 <option value="0" selected>Todos</option>
                 <?php foreach ($categorias as $categoria) {
                     echo '<option value="'.$categoria['id'].'">'.$categoria['nome'].'</option>';
                 }?>
             </select>

            <button id="botao_filtrar">Filtrar</button>

        </div>


    <table>
        <thead>
            <tr>
                <th>Data</th>
                <th>Descrição</th>
                <th>Categoria</th>
                <th>Valor</th>
            </tr>
        </thead>

        <tbody id="tabela-movimentacoes">
        </tbody>
    </table>

    </section>
</body>
</html>
