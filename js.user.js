//FORMULARIO DE EMPRESTIMOS 
$(document).ready(function () {
    $('#btn-alugar').on('click', function (e) {
        e.preventDefault(); // Impede o envio do formulário padrão

        var livroId = $('#livro').val();
        var andar = $('#andar').val();
        var usuario = $('#usuarioEmail').val();
        var mtUser = $('#mtUser').val();

        if (livroId === "" || andar === "") {
            $('#successModalLabel').text("Erro"); // Muda o título do modal para 'Erro'
            $('#modalMessage').html("Preencha todos os campos para realizar o empréstimo."); // Mensagem de erro
            $('#modalMessage').css('color', 'red'); // Define a cor do texto para vermelho

            // Exibe o modal de erro
            $('#successModal').modal('show');
            return;
        }

        $.ajax({
            url: 'http://localhost/projeto-biblioteca/private/controller/User-controller.php',
            type: 'POST',
            data: {
                livroId: livroId,
                andar: andar,
                usuario: usuario,
                mtUser: mtUser,
            },
            dataType: 'json',
            success: function (response) {
                var modalMessage = $('#modalMessage');
                var modalTitle = $('#successModalLabel');

                if (response.nomeLivro) {
                    modalMessage.html(response.message + "<br><strong>Livro: " + response.nomeLivro + "</strong>");
                    modalMessage.css('color', 'green'); 
                    modalTitle.text("Boa leitura"); 
                } else {
                    // Caso o nome do livro não esteja presente 
                    modalMessage.html(response.message);
                    modalMessage.css('color', 'red');
                    modalTitle.text("Erro");
                }

                // Exibe o modal de sucesso/erro
                $('#successModal').modal('show');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                // Em caso de erro de requisição AJAX, exibe o alerta
                alert("Erro: " + textStatus + " - " + errorThrown);
            }

        });
    });
});


// RENOVAÇÃO DE EMPRÉSTIMOS
$(document).ready(function () {
    $('#btn-renovar').click(function () {
        var emprestimoId = $('#emprestimo').val();
        var usuarioId = $('#usuarioEmail').val();
        var mtUser = $('#mtUser2').val();

        if (emprestimoId === "") {
            $("#warningModal").modal('show');
            var modalPreencha =   $("#warningModal");
            modalPreencha.css('color', 'red');
            return;
        }

        $.ajax({
            url: 'http://localhost/projeto-biblioteca/private/controller/User-controller.php',
            type: 'POST',
            dataType: 'json', 
            data: {
                emprestimoId: emprestimoId,
                usuario: usuarioId,
                mtUser: mtUser,
            },
            success: function (response) {
                var modalMessage = $('#modalMessage');

                console.log(response); // Verifica a resposta
                if (response.status) {
                    $("#modalMessage").text(response.message);
                    modalMessage.css('color', 'green');
                    $("#successModal").modal('show');
                } else {
                    $("#modalMessage").text(response.message);
                    modalMessage.css('color', 'red');
                    $("#renewModal").modal('show');
                }
            },
            error: function (xhr, status, error) {
                console.error("Status:", status);
                console.error("Error:", error);
                console.error("Response:", xhr.responseText); // Mostra a resposta do servidor
                $("#modalMessage").text("Erro ao renovar o empréstimo. Tente novamente mais tarde.");
                $("#renewModal").modal('show');
            }
        });
    });
});

