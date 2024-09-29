
// FUNÇÃO PARA ADICIONAR LIVROS
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
        var mtAdmin = document.getElementById('mtAdmin').value;

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
                    andar: andar,
                    mtAdmin: mtAdmin
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


// relatorio de empréstimos

document.addEventListener('DOMContentLoaded', function () {
    const botaoBusca = document.getElementById('botaoBusca');

    botaoBusca.addEventListener('click', function () {
        buscarEmprestimos();
    });

    function buscarEmprestimos() {
        const mes = document.getElementById("mes").value;

        if (!mes) {
            document.getElementById("mensagem").innerHTML = `<p style="color: red;">Por favor, selecione um mês.</p>`;
            return;
        }

        $.ajax({
            url: "http://localhost/projeto-biblioteca/private/controller/Admin.Controller.php",
            method: "POST",
            async: true,
            data: {
                mes: mes,
                mtAdmin: 'relatorio'
            }
        })
            .done(function (result) {
                if (result.status) {
                    const tbody = document.querySelector('tbody');
                    tbody.innerHTML = ''; // Limpa a tabela antes de adicionar novos dados

                    result.data.forEach(function (emprestimo) {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                        <td>${emprestimo.nomeLivro}</td>
                        <td>${emprestimo.nomeUsuario}</td>
                        <td>${emprestimo.dataEmprestimo}</td>
                        <td>${emprestimo.dataDevolucao}</td>
                        <td>${emprestimo.status}</td>
                    `;
                        tbody.appendChild(row);
                    });
                } else {
                    $('#mensagem').html(result.msg).addClass("error");
                }
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                $('#mensagem').html("Ocorreu um erro: " + textStatus).addClass("error");
            });
    }
});






































