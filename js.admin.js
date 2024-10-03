
// FUNÇÃO PARA ADICIONAR LIVROS
const cadLivro = document.getElementById('cad-livro');
if (cadLivro) {
    cadLivro.addEventListener('click', function (event) {
        event.preventDefault();

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

    botaoBusca.addEventListener('click', function (event) {
        buscarEmprestimos();
        event.preventDefault();
    });

    function buscarEmprestimos() {
        const mes = document.getElementById("mes").value;
        const ano = document.getElementById("ano").value;
        const mtAdmin = document.getElementById('mtAdmin').value;

        if (!mes || !ano) {
            document.getElementById("mensagem").innerHTML = `<p style="color: red;">Por favor, selecione um mês/ano.</p>`;
            return;
        }

        $.ajax({
            type: "POST",
            url: "http://localhost/projeto-biblioteca/private/controller/Admin.Controller.php",
            data: { mes: mes, ano: ano, mtAdmin: mtAdmin },
            success: function (result) {
                console.log(result);

                // Limpa o conteúdo anterior do tbody
                $("#resultadoEmprestimos").empty();

                if (result.status) {
                    // Popula o tbody com os dados recebidos
                    result.data.forEach(function (emprestimo) {
                        $("#resultadoEmprestimos").append(
                            `<tr>
            <td>${emprestimo.nomeLivro}</td>
            <td>${emprestimo.nomeUsuario}</td>
            <td>${emprestimo.dataRetirada}</td>
            <td>${emprestimo.dataEntrega}</td> 
            <td>
                <select class="status-dropdown" data-emprestimo-id="${emprestimo.idEmprestimo}">
                    <option value="5" ${emprestimo.status === 'Emprestado' ? 'selected' : ''}>Emprestado</option>
                    <option value="6" ${emprestimo.status === 'Devolvido' ? 'selected' : ''}>Devolvido</option>
                </select>
                <button class="atualizar-status" data-emprestimo-id="${emprestimo.idEmprestimo}">Atualizar</button>
            </td>
        </tr>`
                        );
                    });
                    AtualizarStatus();

                } else {
                    // Caso não haja dados, exibe a mensagem apropriada
                    $("#resultadoEmprestimos").append(
                        `<tr>
                            <td colspan="5">${result.msg}</td>
                        </tr>`
                    );
                }
            },
        });
    }

    // Função para adicionar os eventos de clique no botão de atualizar status
    function AtualizarStatus() {
        const atualizarButtons = document.querySelectorAll('.atualizar-status');

        atualizarButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                const emprestimoId = this.getAttribute('data-emprestimo-id');
                const novoStatus = this.previousElementSibling.value; // Obtém o valor do dropdown
                const mtAdmin = 'atualizarStatusEmprestimo';

                if (!novoStatus) {
                    alert('Por favor, selecione um novo status.');
                    return;
                }

                console.log('ID do Empréstimo:', emprestimoId);
                console.log('Novo Status:', novoStatus);
                console.log('mtAdmin:', mtAdmin);


                // Faz a requisição AJAX para atualizar o status no backend
                $.ajax({
                    type: "POST",
                    url: "http://localhost/projeto-biblioteca/private/controller/Admin.Controller.php?action=atualizar-status",
                    data: {
                        emprestimoId: emprestimoId,
                        novoStatus: novoStatus,
                        mtAdmin: mtAdmin
                    },
                    success: function (result) {
                        if (result.status) {
                            alert('Status atualizado com sucesso!');
                        } else {
                            alert('Erro ao atualizar status: ' + result.msg);
                        }
                    },
                    error: function (error) {
                        console.error('Erro ao atualizar status:', error);
                    }
                });
            });
        });
    }

});







































