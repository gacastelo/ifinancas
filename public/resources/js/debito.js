const URL_DEBITO = "../controller/DebitoController.php";

$(document).ready(function() {
    $("#formCriarDebito").on("submit", function(e) {
        e.preventDefault();
        requisitarAjax(URL_DEBITO, "POST", $(this).serialize());
    });

    $("#formBuscarDebito").on("submit", function(e) {
        e.preventDefault();
        requisitarAjax(URL_DEBITO + "?" + $(this).serialize(), "GET");
    });

    $("#formAtualizarDebito").on("submit", function(e) {
        e.preventDefault();
        const id = $(this).find('[name="id"]').val();
        requisitarAjax(URL_DEBITO + "?id=" + encodeURIComponent(id), "PUT", $(this).serialize());
    });

    $("#formExcluirDebito").on("submit", function(e) {
        e.preventDefault();
        requisitarAjax(URL_DEBITO, "DELETE", $(this).serialize());
    });
});
