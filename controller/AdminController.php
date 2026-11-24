<?php

require_once "../service/RequerimentoService.php";

session_start();

header("Content-Type: text/plain; charset=utf-8");

if (!isset($_SESSION["idUsuario"])) {
    http_response_code(401);
    exit("Usuário não autenticado.");
}

if ($_SESSION["isAdmin"] != 1) {
    http_response_code(403);
    exit("Acesso negado.");
}


$service = new RequerimentoService();

try {

    switch ($_SERVER["REQUEST_METHOD"]) {

        case "PUT":

            parse_str(file_get_contents("php://input"), $dados);

            $id = (int)($_GET["id"] ?? 0);

            if ($id <= 0) {
                http_response_code(400);
                exit("ID inválido.");
            }

            $service->aprovarRequerimento(
                $id,
                (int)$_SESSION["idUsuario"]
            );

            http_response_code(200);
            exit("Requerimento aprovado com sucesso.");

        default:

            http_response_code(405);
            exit("Método não permitido.");
    }

} catch (Throwable $e) {

    error_log($e->getMessage());

    http_response_code(500);
    exit("Erro ao processar operação administrativa.");
}