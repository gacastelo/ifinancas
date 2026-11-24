function requisitarAjax(url, metodo, dados = {}) {
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
    const resultado = document.getElementById("resultado");

    if (!resultado) {
        alert(tipo + "\n" + resposta);
        return;
    }

    if (resultado.textContent === "Nenhuma requisição realizada.") {
        resultado.textContent = "";
    }

    resultado.textContent =
        "==============================\n" +
        tipo + "\n" +
        "Método: " + metodo + "\n" +
        "URL: " + url + "\n" +
        "Resposta:\n" + resposta + "\n\n" +
        resultado.textContent;
}

$("#limparResultado").on("click", function() {
    $("#resultado").text("Nenhuma requisição realizada.");
});