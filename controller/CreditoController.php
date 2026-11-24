
<?php

require_once "../model/Credito/Credito.php";
require_once "../model/Credito/CreditoDTO.php";
require_once "../service/CreditoService.php";

session_start();

header("Content-Type: text/plain; charset=utf-8");

if (!isset($_SESSION["idUsuario"])) {
    http_response_code(401);
    exit("Usuário não autenticado.");
}
$service = new CreditoService();

function isAdmin(): void
{
    if ($_SESSION["isAdmin"] != 1){
        http_response_code(403);
        exit("Acesso negado.");
    }
}


try {

    switch ($_SERVER["REQUEST_METHOD"]) {

        case "POST":
            isAdmin();

            $data = new DateTime($_POST["data"]);

            $DTO = new CreditoDTO(
                $data,
                $_POST["descricao"],
                (int) $_POST["valorEmCentavos"],
                (int) $_POST["idCategoria"],
                (int) $_SESSION["idUsuario"]
            );

            $service->saveCredito($DTO);

            http_response_code(201);
            exit("Credito cadastrado com sucesso.");

        case "GET":
            $id = (int) ($_GET["id"] ?? 0);
            if ($id < 0) {
                http_response_code(400);
                exit("ID inválido.");
            }

            if ($id === 0){
                $creditos = $service->getAll();
                exit(print_r($creditos, true));
            }

            $credito = $service->getCredito($id);
            if ($credito === null) {
                http_response_code(404);
                exit("Credito não encontrada.");
            }
            exit((string) $credito);
        case "PUT":

            isAdmin();

            parse_str(file_get_contents("php://input"), $dados);
            $id = (int) ($_GET["id"] ?? 0);
            if ($id <= 0) {
                http_response_code(400);
                exit("ID inválido.");
            }
            $DTO = new CreditoDTO(
                new DateTime($dados["data"]),
                $dados["descricao"],
                (int) $dados["valorEmCentavos"],
                (int) $dados["idCategoria"],
                (int) $_SESSION["idUsuario"]
            );
            $service->updateCredito($id, $DTO);
            http_response_code(200);
            exit("Credito atualizado com sucesso.");

        case "DELETE":

            isAdmin();

            parse_str(file_get_contents("php://input"), $dados);
            $id = (int) ($dados["id"] ?? 0);
            if ($id <= 0) {
                http_response_code(400);
                exit("ID inválido." . $id);
            }
            $service->deleteCredito($id);
            http_response_code(200);
            exit("Credito excluído com sucesso.");
        default:
            http_response_code(405);
            exit("Método não permitido.");
    }

} catch (Throwable $e) {
    http_response_code(500);
    exit("Erro ao processar Credito." . "<br> Erro:" . $e->getMessage());
}
