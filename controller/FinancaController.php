
<?php

require_once "../model/Financa/Financa.php";
require_once "../model/Financa/FinancaDTO.php";
require_once "../service/FinancaService.php";

session_start();

header("Content-Type: text/plain; charset=utf-8");

if (!isset($_SESSION["idUsuario"])) {
    http_response_code(401);
    exit("Usuário não autenticado.");
}
$service = new FinancaService();
try {

    switch ($_SERVER["REQUEST_METHOD"]) {

        case "POST":

            $data = new DateTime($_POST["data"]);

            $DTO = new FinancaDTO(
                $data,
                $_POST["descricao"],
                (int) $_POST["valorEmCentavos"],
                (int) $_POST["idCategoria"],
                (int) $_SESSION["idUsuario"]
            );

            $service->saveFinanca($DTO);

            http_response_code(201);
            exit("Financa cadastrado com sucesso.");

        case "GET":
            $id = (int) ($_GET["id"] ?? 0);
            if ($id <= 0) {
                http_response_code(400);
                exit("ID inválido.");
            }
            $financa = $service->getFinanca($id);
            if ($financa === null) {
                http_response_code(404);
                exit("Financa não encontrada.");
            }
            exit((string) $financa);
        case "PUT":
            parse_str(file_get_contents("php://input"), $dados);
            $id = (int) ($_GET["id"] ?? 0);
            if ($id <= 0) {
                http_response_code(400);
                exit("ID inválido.");
            }
            $DTO = new FinancaDTO(
                new DateTime($dados["data"]),
                $dados["descricao"],
                (int) $dados["valorEmCentavos"],
                (int) $dados["idCategoria"],
                (int) $_SESSION["idUsuario"]
            );
            $service->updateFinanca($id, $DTO);
            http_response_code(200);
            exit("Financa atualizado com sucesso.");

        case "DELETE":
            parse_str(file_get_contents("php://input"), $dados);
            $id = (int) ($dados["id"] ?? 0);
            if ($id <= 0) {
                http_response_code(400);
                exit("ID inválido." . $id);
            }
            $service->deleteFinanca($id);
            http_response_code(200);
            exit("Financa excluído com sucesso.");
        default:
            http_response_code(405);
            exit("Método não permitido.");
    }

} catch (Throwable $e) {
    http_response_code(500);
    exit("Erro ao processar financa." . "<br> Erro:" . $e->getMessage());
}
