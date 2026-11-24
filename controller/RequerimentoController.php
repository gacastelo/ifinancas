
<?php

require_once "../model/Requerimento/Requerimento.php";
require_once "../model/Requerimento/RequerimentoDTO.php";
require_once "../service/RequerimentoService.php";

session_start();

header("Content-Type: text/plain; charset=utf-8");

if (!isset($_SESSION["idUsuario"])) {
    http_response_code(401);
    exit("Usuário não autenticado.");
}
$service = new RequerimentoService();
try {

    switch ($_SERVER["REQUEST_METHOD"]) {

        case "POST":

            $data = new DateTime($_POST["data"]);

            $DTO = new RequerimentoDTO(
                $data,
                $_POST["descricao"],
                (int) $_POST["valorEmCentavos"],
                (int) $_POST["idCategoria"],
                (int) $_SESSION["idUsuario"]
            );

            $service->saveRequerimento($DTO);

            http_response_code(201);
            exit("Requerimento cadastrado com sucesso.");

        case "GET":

            $id = (int) ($_GET["id"] ?? 0);
            if ($id < 0) {
                http_response_code(400);
                exit("ID inválido.");
            }

            if ($id === 0){
                $requerimentos = $service->getAll();
                exit(print_r($requerimentos, true));
            }

            $requerimento = $service->getRequerimento($id);
            if ($requerimento === null) {
                http_response_code(404);
                exit("Requerimento não encontrado.");
            }
            exit((string) $requerimento);
        case "PUT":
            parse_str(file_get_contents("php://input"), $dados);
            $id = (int) ($_GET["id"] ?? 0);
            if ($id <= 0) {
                http_response_code(400);
                exit("ID inválido.");
            }
            $DTO = new RequerimentoDTO(
                new DateTime($dados["data"]),
                $dados["descricao"],
                (int) $dados["valorEmCentavos"],
                (int) $dados["idCategoria"],
                (int) $_SESSION["idUsuario"]
            );
            $service->updateRequerimento($id, $DTO);
            http_response_code(200);
            exit("Requerimento atualizado com sucesso.");

        case "DELETE":
            parse_str(file_get_contents("php://input"), $dados);
            $id = (int) ($dados["id"] ?? 0);
            if ($id <= 0) {
                http_response_code(400);
                exit("ID inválido." . $id);
            }
            $service->deleteRequerimento($id);
            http_response_code(200);
            exit("Requerimento excluído com sucesso.");
        default:
            http_response_code(405);
            exit("Método não permitido.");
    }

} catch (Throwable $e) {
    http_response_code(500);
    exit("Erro ao processar requerimento." . "<br> Erro:" . $e->getMessage());
}
