const URL_FINANCA = "controller/FinancaController.php";

$("#formCriarFinanca").on("submit", function(e) {
    e.preventDefault();
    requisitarAjax(URL_FINANCA, "POST", $(this).serialize());
});

$("#formBuscarFinanca").on("submit", function(e) {
    e.preventDefault();
    const dados = Object.fromEntries(new FormData(this));
    const id = dados.id;
    requisitarAjax(URL_FINANCA + "?id=" + encodeURIComponent(id), "GET");
});

$("#formAtualizarFinanca").on("submit", function(e) {
    e.preventDefault();
    const dados = Object.fromEntries(new FormData(this));
    const id = dados.id;
    delete dados.id;
    requisitarAjax(URL_FINANCA + "?id=" + encodeURIComponent(id), "PUT", dados);
});

$("#formExcluirFinanca").on("submit", function(e) {
    e.preventDefault();
    const dados = Object.fromEntries(new FormData(this));
    requisitarAjax(URL_FINANCA, "DELETE", dados);
});