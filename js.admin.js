const cadLivro = document.getElementById('cad-livro');
if (cadLivro) {
    cadLivro.addEventListener('click', function (event) {
        event.preventDefault(); // Previne o envio normal do formulário, essencial se o botão estiver dentro de um <form>

        var nomeLivro = document.getElementById("nomeLivro").value;
        var quantidade = document.getElementById("quantLivro").value;
        var condicao = document.getElementById("condLivro").value;
        var codigo = document.getElementById("codigoLivro").value;
        var autor = document.getElementById("autorLivro").value;
        var andar = document.getElementById('andar').value;

        // Verifica se todos os campos obrigatórios estão preenchidos
        if (!nomeLivro || !quantidade || !condicao || !codigo || !autor || !andar) {
            document.getElementById("mensagem").innerHTML = `<p style="color: red;">Por favor, preencha todos os campos.</p>`;
            return;
        }else{
             // Envia os dados para o controller via AJAX
             $.ajax({
                url: "http://localhost/projeto-biblioteca/private/controller/Admin.Controller.php",
                method: "POST",
                async: true,
                data: {
                 nomeLivro: nomeLivro,
                 quantidade: quantidade,
                 condicao: condicao,
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





























        // Criando um objeto com os dados
        // var dadosLivro = {
        //     nomeLivro: nomeLivro,
        //     quantidade: quantidade,
        //     condicao: condicao,
        //     codigo: codigo,
        //     autor: autor
        // };

        // Enviando os dados via fetch (AJAX)
    //     fetch('http://localhost/projeto-biblioteca/private/controller/Admin.Controller.php', {
    //         method: 'POST',
    //         headers: {
    //             'Content-Type': 'application/json'
    //         },
    //         body: JSON.stringify(dadosLivro)
    //     })
    
    //         .then(response => response.json()) // Convertendo a resposta em JSON
    //         .then(data => {
    //             var mensagemDiv = document.getElementById("mensagem");
    //             if (data.sucesso) {
    //                 mensagemDiv.innerHTML = `<p style="color: green;">${data.mensagem}</p>`;
    //             } else {
    //                 mensagemDiv.innerHTML = `<p style="color: red;">${data.mensagem}</p>`;
    //             }
    //         })
    //         .catch(error => {
    //             console.error('Erro:', error);
    //             document.getElementById("mensagem").innerHTML = `<p style="color: red;">Erro ao enviar os dados.</p>`;
    //         });
    // });

