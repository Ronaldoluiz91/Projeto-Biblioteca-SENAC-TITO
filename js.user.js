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
    // Ao clicar no botão de renovar
    $('.btn-renovar').click(function () {
        var emprestimoId = $(this).data('id');  
        var usuarioId = $('#usuarioEmail').val(); 
        var mtUser = $('#mtUser2').val();  // Valor oculto de controle

        if (!emprestimoId) {
            $("#modalMessage2").text("Erro ao identificar o empréstimo para renovação.");
            $("#renewModalLabel").text("Erro na Renovação");
            $("#renewModal").modal('show');
            return;
        }

        // Requisição AJAX
        $.ajax({
            url: 'http://localhost/projeto-biblioteca/private/controller/User-controller.php',  
            type: 'POST',
            data: {
                emprestimoId: emprestimoId,
                usuario: usuarioId,
                mtUser: mtUser,
            },
            success: function (response) {
                console.log("Resposta recebida:", response);

                try {
                    // Verifica se a resposta está em formato JSON
                    if (typeof response === 'string') {
                        response = JSON.parse(response);
                    }

                    // Atualiza o modal de acordo com o status da resposta
                    $("#renewModalLabel").text(response.status ? "Renovação Bem-Sucedida" : "Erro na Renovação");

                    // Mensagem de sucesso ou erro
                    $("#modalMessage2").text(response.message);
                } catch (e) {
                    console.error("Erro ao processar a resposta:", e);
                    $("#modalMessage2").text("Erro ao processar a resposta do servidor.");
                    $("#renewModalLabel").text("Erro na Renovação");
                }

                // Exibe o modal com o resultado da ação
                $("#renewModal").modal('show');
            },

            error: function (xhr, status, error) {
                console.error("Erro na requisição AJAX:", status, error);
                $("#modalMessage2").text("Erro ao renovar o empréstimo. Tente novamente mais tarde.");
                $("#renewModal").modal('show');
            }
        });
    });
});




