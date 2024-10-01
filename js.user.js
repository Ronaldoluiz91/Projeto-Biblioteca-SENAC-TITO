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
            $("#modalMessage2").text("Por favor, selecione um empréstimo ativo para renovar.");
            $("#renewModalLabel").text("Erro na Renovação"); 
            $("#renewModal").modal('show');
            return;
        }

        $.ajax({
            url: 'http://localhost/projeto-biblioteca/private/controller/User-controller.php',
            type: 'POST',
            data: {
                emprestimoId: emprestimoId,
                usuario: usuarioId,
                mtUser: mtUser,
            },
            success: function (response) {
                console.log("Raw response:", response);
                console.log("Tipo da resposta:", typeof response);

                try {
                    $("#renewModalLabel").text(response.status ? "Renovação Bem-Sucedida" : "Erro na Renovação"); // Atualiza o título do modal

                    if (response.status) {
                        // Mensagem de sucesso
                        $("#modalMessage2").text(response.message);
                    } else {
                        // Mensagem de erro
                        $("#modalMessage2").text("Erro: " + response.message);
                    }
                } catch (e) {
                    console.error("Erro ao processar a resposta:", e);
                    $("#modalMessage2").text("Erro ao processar a resposta do servidor."); // Mensagem de erro
                    $("#renewModalLabel").text("Erro na Renovação"); // Atualiza o título para erro
                }
                $("#renewModal").modal('show');
            },

            error: function (xhr, status, error) {
                console.error("Status:", status); // Mostra o status da requisição
                console.error("Error:", error); // Mostra o erro
                console.error("Response:", xhr.responseText); // Mostra a resposta do servidor
                $("#modalMessage2").text("Erro ao renovar o empréstimo. Tente novamente mais tarde."); // Mensagem de erro
                $("#renewModal").modal('show'); // Exibe o modal de erro
            }
        });
    });
});



