const URL_CREDITO = "../controller/CreditoController.php";

$(document).ready(function() {
    $("#formCriarCredito").on("submit", function(e) {
        e.preventDefault();
        requisitarAjax(URL_CREDITO, "POST", $(this).serialize());
    });

    $("#formBuscarCredito").on("submit", function(e) {
        e.preventDefault();
        requisitarAjax(URL_CREDITO + "?" + $(this).serialize(), "GET");
    });

    $("#formAtualizarCredito").on("submit", function(e) {
        e.preventDefault();
        const id = $(this).find('[name="id"]').val();
        requisitarAjax(URL_CREDITO + "?id=" + encodeURIComponent(id), "PUT", $(this).serialize());
    });

    $("#formExcluirCredito").on("submit", function(e) {
        e.preventDefault();
        requisitarAjax(URL_CREDITO, "DELETE", $(this).serialize());
    });
});
