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
                if (response.nomeLivro) {
                    // Se o nome do livro estiver presente
                    $('#modalMessage').html(response.message + "<br><strong>Livro: " + response.nomeLivro + "</strong>");
                } else {
                    // Caso o nome do livro não esteja presente (erro de livro não encontrado)
                    $('#modalMessage').html(response.message);
                }

                // Exibe o modal de sucesso
                $('#successModal').modal('show');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Erro: " + textStatus + " - " + errorThrown);
            }
        });
    });
});
