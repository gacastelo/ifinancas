<?php
require_once "../service/CategoriaService.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $categoriaService = new CategoriaService();
    $categoriaService->saveCategoria($_POST["nome"]);
}
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $categoriaService = new CategoriaService();
    print_r($categoriaService->getAll());
}
?>
<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>Teste</title>
</head>
<body>
    <form method="post">
        <input type="text" name="nome">
        <button type="submit">Enviar</button>
    </form>
</body>
</html>
