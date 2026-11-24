const URL_REQUERIMENTO = "controller/RequerimentoController.php";

$(document).ready(function() {
    $("#formCriarRequerimento").on("submit", function(e) {
        e.preventDefault();
        requisitarAjax(URL_REQUERIMENTO, "POST", $(this).serialize());
    });

    $("#formBuscarRequerimento").on("submit", function(e) {
        e.preventDefault();
        requisitarAjax(URL_REQUERIMENTO + "?" + $(this).serialize(), "GET");
    });

    $("#formAtualizarRequerimento").on("submit", function(e) {
        e.preventDefault();
        const id = $(this).find('[name="id"]').val();
        requisitarAjax(URL_REQUERIMENTO + "?id=" + encodeURIComponent(id), "PUT", $(this).serialize());
    });

    $("#formExcluirRequerimento").on("submit", function(e) {
        e.preventDefault();
        requisitarAjax(URL_REQUERIMENTO, "DELETE", $(this).serialize());
    });
});
