<?php
session_start();

$usuarios = [
    'aluno1' => ['senha' => '123', 'tipo' => 'requerente'],
    'aluno2' => ['senha' => '456', 'tipo' => 'requerente'],
    'aluno3' => ['senha' => '789', 'tipo' => 'requerente'],
    'adm'    => ['senha' => '123', 'tipo' => 'adm']
];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome_usuario = $_POST['nome_usuario'] ?? '';
    $senha = $_POST['senha'] ?? '';

    if (isset($usuarios[$nome_usuario]) && 
        $usuarios[$nome_usuario]['senha'] === $senha) {

        $_SESSION['usuario'] = $nome_usuario;
        $_SESSION['tipo'] = $usuarios[$nome_usuario]['tipo'];

        if ($_SESSION['tipo'] == 'requerente') {
            header('Location: ../menu/pag_inicial_req.html');
            exit();
        }

        elseif ($_SESSION['tipo'] == 'adm') {
            header('Location: ../menu/pag_inicial_adm.html');
            exit();
        }

    } else {
        header('Location: login.html');
        exit();
    }
}
?>
