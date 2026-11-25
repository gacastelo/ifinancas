const URL_USUARIO = "../controller/UserController.php";

$(document).ready(function() {
    $("#formCadastro").on("submit", function(e) {
        e.preventDefault();
        $.ajax({
            url: URL_USUARIO,
            method: "POST",
            data: $(this).serialize(),
            dataType: "text",
            success: function(resposta) {
                window.location.href = "../public/login.php";
            },
            error: function(xhr) {
                $("#message").text(xhr.responseText);
            }
        });
    });

    $("#formLogin").on("submit", function(e) {
        e.preventDefault();
        $.ajax({
            url: URL_USUARIO,
            method: "POST",
            data: $(this).serialize() + "&acao=login",
            dataType: "text",
            success: function() {
                window.location = "../public/"
            },
            error: function(xhr) {
                $("#message").text(xhr.responseText);
            }
        });
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
