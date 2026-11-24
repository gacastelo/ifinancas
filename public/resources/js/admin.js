const URL_ADMIN = "controller/AdminController.php";

$(document).ready(function() {
    $("#formAprovarRequerimento").on("submit", function(e) {
        e.preventDefault();
        const id = $(this).find('[name="id"]').val();
        requisitarAjax(URL_ADMIN + "?id=" + encodeURIComponent(id), "PUT");
    });
});
