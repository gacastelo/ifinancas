const URL_USUARIO = "controller/UsuarioController.php";

$(document).ready(function() {
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
        requisitarAjax(URL_USUARIO + "?" + $(this).serialize(), "GET");
    });

    $("#formAtualizarUsuario").on("submit", function(e) {
        e.preventDefault();
        const id = $(this).find('[name="id"]').val();
        requisitarAjax(URL_USUARIO + "?id=" + encodeURIComponent(id), "PUT", $(this).serialize());
    });

    $("#formExcluirUsuario").on("submit", function(e) {
        e.preventDefault();
        requisitarAjax(URL_USUARIO, "DELETE", $(this).serialize());
    });
});
