//FORMULARIO DE EMPRESTIMOS 

$(document).ready(function () {
    $('#btn-alugar').on('click', function (e) {
        e.preventDefault(); // Impede o envio do formulário padrão

        var livroId = $('#livro').val();
        var andar = $('#andar').val();
        var usuario = $('#usuarioEmail').val();

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

            },
            dataType: 'json',
            success: function (response) {
                var modalMessage = $('#modalMessage');
                var modalTitle = $('#successModalLabel');

                if (response.nomeLivro) {
                    // Se o nome do livro estiver presente, exibe mensagem com o livro
                    modalMessage.html(response.message + "<br><strong>Livro: " + response.nomeLivro + "</strong>");
                    modalMessage.css('color', 'green'); // Cor verde para sucesso
                    modalTitle.text("Boa leitura"); // Título de sucesso
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
