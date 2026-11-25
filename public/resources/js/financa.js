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


    $("#botao_filtrar").on("click", buscar);
    function buscar() {

        $.ajax({
            url: "../controller/FinancaController.php",
            method: "GET",
            data: {
                action: "filtrar",
                type: $("#tipo").val().toUpperCase(),
                dataInicio: $("#data_inicio").val(),
                dataFinal: $("#data_fim").val(),
                categoriaId: $("#categoria").val()
            },

            success: function (resposta) {
                const financas = JSON.parse(resposta);

                const tabela = $("#tabela-movimentacoes");
                tabela.empty();

                financas.forEach(function (financa) {

                    const data = financa.data.split("-").reverse().join("/");

                    const valor = (financa.valorEmCentavos / 100).toLocaleString("pt-BR", {style: "currency", currency: "BRL"});
                    tabela.append(`
                    <tr>
                        <td>${data}</td>
                        <td>${financa.descricao}</td>
                        <td>${financa.categoria}</td>
                        <td>${valor}</td>
                    </tr>
                `);
                });
            },
            error: function (xhr) {
                console.log(xhr.responseText);
            }
        });
    }
    buscar();
});
