const cadLivro = document.getElementById('cad-livro');
if (cadLivro) {
    cadLivro.addEventListener('click', function (event) {
        event.preventDefault(); // Previne o envio normal do formulário, essencial se o botão estiver dentro de um <form>

        var nomeLivro = document.getElementById("nomeLivro").value;
        var quantidade = document.getElementById("quantLivro").value;
        var condicao = document.getElementById("condLivro").value;
        var anoLancamento = document.getElementById("anoLancamento").value;
        var codigo = document.getElementById("codigoLivro").value;
        var autor = document.getElementById("autorLivro").value;
        var andar = document.getElementById('andar').value;

        // Verifica se todos os campos obrigatórios estão preenchidos
        if (!nomeLivro || !quantidade || !condicao || !codigo || !autor || !andar || !anoLancamento) {
            document.getElementById("mensagem").innerHTML = `<p style="color: red;">Por favor, preencha todos os campos.</p>`;
            return;
        } else {
            // Envia os dados para o controller via AJAX
            $.ajax({
                url: "http://localhost/projeto-biblioteca/private/controller/Admin.Controller.php",
                method: "POST",
                async: true,
                data: {
                    nomeLivro: nomeLivro,
                    quantidade: quantidade,
                    condicao: condicao,
                    anoLancamento: anoLancamento,
                    codigo: codigo,
                    autor: autor,
                    andar: andar
                }
            })
                .done(function (result) {
                    if (result['status']) {
                        $('#mensagem').removeClass("error");
                        $('#mensagem').html(result.msg).addClass("sucess");
                    } else {
                        $('#mensagem').html(result.msg).addClass("error");

                    }
                })
        }

    });
}


//FORMULARIO DE EMPRESTIMOS 

$(document).ready(function () {
    $('#btn-alugar').on('click', function (e) {
        e.preventDefault(); // Impede o envio do formulário padrão

        var livroId = $('#livro').val();

        if (livroId === "") {
            alert("Por favor, selecione um livro.");
            return;
        }

        $.ajax({
            url: 'http://localhost/projeto-biblioteca/private/controller/User-controller.php',
            type: 'POST',
            data: {
                livroId: livroId
            },
            dataType: 'json',
            success: function (response) {
                alert(response.message); // Mostra a mensagem retornada
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Erro: " + textStatus + " - " + errorThrown);
            }
        });
    });
});
































