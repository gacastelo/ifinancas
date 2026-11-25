<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="resources/css/login.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="resources/js/usuario.js" defer></script>
</head>
<body>
    <div class="bloco1">
    <form id="formLogin" method="post">
        <h1>Login</h1>
        <p>Email:</p>
        <input type="text" name="email" placeholder="Ex: joaozinho_pamonha123" class="caixa1" required><br>
        <p>Senha:</p>
        <input type="password" name="senha" placeholder="Ex:  senha" class="caixa1" required><br><br>
        <p id="message"></p>
        <input  type="submit" value="Entrar" class="botao1">
        <br><br>
        <p><a href="cadastrar.php">Você não possui conta?</a></p>
    </form>
    </div>
</body>
</html>
