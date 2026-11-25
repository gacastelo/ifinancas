
<?php

require_once "../model/Financa/Financa.php";
require_once "../model/Financa/FinancaDTO.php";
require_once "../service/FinancaService.php";
require_once "../service/CategoriaService.php";

session_start();

header("Content-Type: text/plain; charset=utf-8");

function userIsLogged(): void
{
    if (!isset($_SESSION["idUsuario"])) {
        http_response_code(401);
        exit("Usuário não autenticado.");
    }
}
function isAdmin(): void
{
    if ($_SESSION["isAdmin"] != 1){
        http_response_code(403);
        exit("Acesso negado.");
    }
}
$service = new FinancaService();
$catService = new CategoriaService();
try {

    switch ($_SERVER["REQUEST_METHOD"]) {

        case "POST":
            userIsLogged();
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

            if (isset($_GET["id"])) {

                $id = (int) $_GET["id"];

                if ($id <= 0) {
                    http_response_code(400);
                    exit("ID inválido.");
                }

                $financa = $service->getFinanca($id);

                if ($financa === null) {
                    http_response_code(404);
                    exit("Finança não encontrada.");
                }

                exit((string) $financa);
            }

            $type = strtoupper($_GET["type"] ?? "ALL");

            $dataInicio = !empty($_GET["dataInicio"])
                ? new DateTime($_GET["dataInicio"])
                : null;

            $dataFinal = !empty($_GET["dataFinal"])
                ? new DateTime($_GET["dataFinal"])
                : null;

            $categoriaId = isset($_GET["categoriaId"])
                ? (int) $_GET["categoriaId"]
                : 0;

            if (!in_array($type, ["ALL", "CREDITO", "DEBITO"])) {
                http_response_code(400);
                exit("Tipo inválido.");
            }

            if ($categoriaId < 0) {
                http_response_code(400);
                exit("Categoria inválida.");
            }

            $financas = $service->getAll(
                $type,
                $dataInicio,
                $dataFinal,
                $categoriaId
            );

            if ($financas === null) {
                exit("Nenhuma finança encontrada.");
            }

            $resultado = [];

            foreach ($financas as $financa) {
                $f = $financa->toArray();
                $f["categoria"] = $catService->getCategoria($f["idCategoria"])->getNome();
                $resultado[] = $f;
            }

            echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
            break;
        case "PUT":
            isAdmin();
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
            isAdmin();
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
