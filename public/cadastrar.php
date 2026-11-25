<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="resources/css/login.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="resources/js/usuario.js" defer></script>
</head>
<body>
<div class="bloco1">
    <form id="formCadastro" method="post">
        <h1>Cadastro</h1>
        <p>Nome:</p>
        <input type="text" name="nome" placeholder="Ex: Maria" class="caixa1" required><br>
        <p>Email:</p>
        <input type="email" name="email" placeholder="Ex: Meu_email@hotemail.com" class="caixa1" required><br>
        <p>Senha:</p>
        <input type="password" name="senha" placeholder="Ex: senha" class="caixa1" required><br>
        <p>Confirmar senha:</p>
        <input type="password" name="senhaConfirma" placeholder="Ex: Confirme sua senha" class="caixa1"
               required><br><br>
        <p id="message"></p>
        <input type="submit" value="Enviar" class="botao1">
    </form>
</div>
</body>
</html>
