<?php
require_once "../model/Debito/Debito.php";
require_once "../model/Debito/DebitoDTO.php";
require_once "../service/DebitoService.php";

session_start();

header("Content-Type: text/plain; charset=utf-8");

if (!isset($_SESSION["idUsuario"])) {
    http_response_code(401);
    exit("Usuário não autenticado.");
}

function isAdmin(): void
{
    if ($_SESSION["isAdmin"] != 1){
        http_response_code(403);
        exit("Acesso negado.");
    }
}


$service  = new DebitoService();
try {
    switch ($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $id = (int) ($_GET["id"] ?? 0);
            if ($id <= 0) {
                http_response_code(400);
                exit("ID inválido.");
            }
            $debito = $service->getDebito($id);
            if ($debito === null) {
                http_response_code(404);
                exit("Débito não encontrado.");
            }
            exit((string) $debito);
        case "PUT":
            isAdmin();

            parse_str(file_get_contents("php://input"), $dados);
            $id = (int) ($_GET["id"] ?? 0);
            if ($id <= 0) {
                http_response_code(400);
                exit("ID inválido.");
            }
            $DTO = new DebitoDTO(
                new DateTime($dados["data"]),
                $dados["descricao"],
                (int) $dados["valorEmCentavos"],
                (int) $dados["idCategoria"],
                (int) $_SESSION["idUsuario"],
                (int) $dados["idRequerimento"]
            );
            $service->updateDebito($id, $DTO);
            http_response_code(200);
            exit("Debito atualizado com sucesso.");
        case "DELETE":
            isAdmin();

            if ($_SESSION["isAdmin"] != 1){
                http_response_code(401);
                exit("Usuário não autenticado.");
            }
            parse_str(file_get_contents("php://input"), $dados);
            $id = (int) ($dados["id"] ?? 0);
            if ($id <= 0) {
                http_response_code(400);
                exit("ID inválido." . $id);
            }
            $service->deleteDebito($id);
            http_response_code(200);
            exit("Debito excluído com sucesso.");
        default:
            http_response_code(405);
            exit("Método não permitido.");
    }
} catch (Throwable $e) {
    http_response_code(500);
    exit("Erro ao processar débito." . "<br> Erro:" . $e->getMessage());
}
