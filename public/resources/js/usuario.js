const URL_USUARIO = "controller/UsuarioController.php";

$("#formCadastro").on("submit", function(e) {
    e.preventDefault();
    requisitarAjax(URL_USUARIO, "POST", $(this).serialize());
});

$("#formLogin").on("submit", function(e) {
    e.preventDefault();
    requisitarAjax(URL_USUARIO, "POST", $(this).serialize() + "&acao=login");
});

$("#formBuscarUsuario").on("submit", function(e) {
    e.preventDefault();
    const dados = Object.fromEntries(new FormData(this));
    requisitarAjax(URL_USUARIO, "GET", dados);
});

$("#formAtualizarUsuario").on("submit", function(e) {
    e.preventDefault();
    const dados = Object.fromEntries(new FormData(this));
    const id = dados.id;
    delete dados.id;
    requisitarAjax(URL_USUARIO + "?id=" + encodeURIComponent(id), "PUT", dados);
});

$("#formExcluirUsuario").on("submit", function(e) {
    e.preventDefault();
    const dados = Object.fromEntries(new FormData(this));
    requisitarAjax(URL_USUARIO, "DELETE", dados);
});