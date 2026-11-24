const URL_REQUERIMENTO = "controller/RequerimentoController.php";

$("#formCriarRequerimento").on("submit", function(e) {
    e.preventDefault();
    requisitarAjax(URL_REQUERIMENTO, "POST", $(this).serialize());
});

$("#formBuscarRequerimento").on("submit", function(e) {
    e.preventDefault();
    const dados = Object.fromEntries(new FormData(this));
    const id = dados.id;
    requisitarAjax(URL_REQUERIMENTO + "?id=" + encodeURIComponent(id), "GET");
});

$("#formAtualizarRequerimento").on("submit", function(e) {
    e.preventDefault();
    const dados = Object.fromEntries(new FormData(this));
    const id = dados.id;
    delete dados.id;
    requisitarAjax(URL_REQUERIMENTO + "?id=" + encodeURIComponent(id), "PUT", dados);
});

$("#formExcluirRequerimento").on("submit", function(e) {
    e.preventDefault();
    const dados = Object.fromEntries(new FormData(this));
    requisitarAjax(URL_REQUERIMENTO, "DELETE", dados);
});