const URL_FINANCA = "../controller/FinancaController.php";

$(document).ready(function() {
    $("#formCriarFinanca").on("submit", function(e) {
        e.preventDefault();
        requisitarAjax(URL_FINANCA, "POST", $(this).serialize());
    });

    $("#formBuscarFinanca").on("submit", function(e) {
        e.preventDefault();
        requisitarAjax(URL_FINANCA + "?" + $(this).serialize(), "GET");
    });

    $("#formAtualizarFinanca").on("submit", function(e) {
        e.preventDefault();
        const id = $(this).find('[name="id"]').val();
        requisitarAjax(URL_FINANCA + "?id=" + encodeURIComponent(id), "PUT", $(this).serialize());
    });

    $("#formExcluirFinanca").on("submit", function(e) {
        e.preventDefault();
        requisitarAjax(URL_FINANCA, "DELETE", $(this).serialize());
    });
});
