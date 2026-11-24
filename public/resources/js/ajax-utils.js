function requisitarAjax(url, metodo, dados = "") {
    $.ajax({
        url: url,
        method: metodo,
        data: dados,
        dataType: "text",
        success: function(resposta) {
            mostrarResultadoAjax("SUCESSO", metodo, url, resposta);
        },
        error: function(xhr) {
            mostrarResultadoAjax("ERRO", metodo, url, "Status HTTP: " + xhr.status + "\n" + xhr.responseText);
        }
    });
}

function mostrarResultadoAjax(tipo, metodo, url, resposta) {

    let r = "==============================\n" +
        tipo + "\n" +
        "Método: " + metodo + "\n" +
        "URL: " + url + "\n" +
        "Resposta:\n" + resposta + "\n\n";

    console.log(r)
    return r;
}

$(document).ready(function() {
    $("#limparResultado").on("click", function() {
        $("#resultado").text("Nenhuma requisição realizada.");
    });
});
