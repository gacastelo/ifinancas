
<?php

require_once "../model/Usuario/Usuario.php";
require_once "../model/Usuario/UsuarioDTO.php";
require_once "../service/UserService.php";

session_start();

header("Content-Type: text/plain; charset=utf-8");

$service = new UserService();

function userLoggedIn(): void
{
    if (!isset($_SESSION["idUsuario"])) {
        http_response_code(401);
        exit("Usuário não autenticado.");
    }
}

try {

    switch ($_SERVER["REQUEST_METHOD"]) {

        case "POST":

            if (($_POST["acao"] ?? "") === "login") {

                $usuario = $service->verificarSenha(
                    $_POST["email"],
                    $_POST["senha"]
                );

                if ($usuario === null) {
                    http_response_code(401);
                    exit("Email ou senha incorretos.");
                }

                $_SESSION["idUsuario"] = $usuario->getId();
                $_SESSION["isAdmin"] = $usuario->isAdmin();

                http_response_code(200);
                exit("Login realizado com sucesso.");
            }

            $DTO = new UsuarioDTO(
                $_POST["nome"],
                $_POST["email"]
            );

            $service->saveUsuario(
                $DTO,
                $_POST["senha"]
            );

            http_response_code(201);
            exit("Usuário cadastrado com sucesso.");

        case "GET":
            userLoggedIn();
            $id = (int) ($_GET["id"] ?? $_SESSION["idUsuario"]);

            if ($id <= 0) {
                http_response_code(400);
                exit("ID inválido.");
            }

            $usuario = $service->getUsuario($id);

            if ($usuario === null) {
                http_response_code(404);
                exit("Usuário não encontrado.");
            }

            exit(
                "ID: " . $usuario->getId() . "\n" .
                "Nome: " . $usuario->getNome() . "\n" .
                "Email: " . $usuario->getEmail() . "\n" .
                "Criado em: " . $usuario->getCreatedAt()->format("d/m/Y H:i:s") . "\n" .
                "Atualizado em: " . $usuario->getUpdatedAt()->format("d/m/Y H:i:s")
            );

        case "PUT":
            userLoggedIn();
            parse_str(file_get_contents("php://input"), $dados);

            $id = (int) ($_GET["id"] ?? $_SESSION["idUsuario"]);

            if ($id <= 0) {
                http_response_code(400);
                exit("ID inválido.");
            }

            $DTO = new UsuarioDTO(
                $dados["nome"],
                $dados["email"]
            );

            $service->updateUsuario($id, $DTO);

            http_response_code(200);
            exit("Usuário atualizado com sucesso.");

        case "DELETE":
            userLoggedIn();
            parse_str(file_get_contents("php://input"), $dados);

            $id = (int) ($dados["id"] ?? $_SESSION["idUsuario"]);

            if ($id <= 0) {
                http_response_code(400);
                exit("ID inválido.");
            }

            $service->deleteUsuario($id);
            if ($id === (int) $_SESSION["idUsuario"]) {
                session_unset();
                session_destroy();
            }

            http_response_code(200);
            exit("Usuário excluído com sucesso.");

        default:

            http_response_code(405);
            exit("Método não permitido.");
    }

} catch (Throwable $e) {

    error_log($e->getMessage());
    http_response_code(500);
    exit("Erro ao processar usuário: " . $e->getMessage());
}
