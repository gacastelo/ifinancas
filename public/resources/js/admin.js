const URL_ADMIN = "controller/AdminController.php";

$("#formAprovarRequerimento").on("submit", function(e) {
    e.preventDefault();
    const dados = Object.fromEntries(new FormData(this));
    const id = dados.id;
    requisitarAjax(URL_ADMIN + "?id=" + encodeURIComponent(id), "PUT");
});