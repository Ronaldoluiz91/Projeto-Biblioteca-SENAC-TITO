
// FUNÇÃO PARA ADICIONAR LIVROS
const cadLivroBtn = document.getElementById('cad-livro');
if (cadLivroBtn) {
    cadLivroBtn.addEventListener('click', function () {
        const nomeLivro = document.getElementById('nomeLivro').value;
        const quantidade = document.getElementById('quantLivro').value;
        const condicao = document.getElementById('condLivro').value;
        const anoLancamento = document.getElementById('anoLancamento').value;
        const codigo = document.getElementById('codigoLivro').value;
        const autor = document.getElementById('autorLivro').value;
        const andar = document.getElementById('andar').value;
        const mtAdmin = document.getElementById('mtAdmin').value;

        if (!nomeLivro || !quantLivro || !condLivro || !anoLancamento || !codigoLivro || !autorLivro || !andar) {
            showModal("Erro no Cadastro", "Por favor, preencha todos os campos.");
        } else {
            // Envia os dados para o controller via AJAX
            $.ajax({
                url: "http://localhost/projeto-biblioteca/private/controller/Admin.controller.php",
                method: "POST",
                async: true,
                dataType: 'json', // Força a resposta como JSON
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
                if (result.status) {
                    showModal("Cadastro Sucesso", result.msg, true); // Título e mensagem em verde
                    // Limpar os campos do formulário
                    document.getElementById('nomeLivro').value = '';
                    document.getElementById('quantLivro').value = '';
                    document.getElementById('condLivro').value = '';
                    document.getElementById('anoLancamento').value = '';
                    document.getElementById('codigoLivro').value = '';
                    document.getElementById('autorLivro').value = '';
                    document.getElementById('andar').value = '';
                } else {
                    showModal("Erro no Cadastro", result.msg, false); // Título e mensagem em vermelho
                }
            });
            

        }
    });
}

// Função para exibir o modal
function showModal(title, message, isSuccess) {
    const modalTitle = document.getElementById('modalLabel');
    const modalMessage = document.getElementById('modalMessage');

    modalTitle.textContent = title;  
    modalMessage.textContent = message; 

   
    modalTitle.classList.remove('modal-title-success', 'modal-title-error');
    modalMessage.classList.remove('modal-success', 'modal-error');

    // Aplica a classe correta com base no status
    if (isSuccess) {
        modalTitle.classList.add('modal-title-success');
        modalMessage.classList.add('modal-success');
    } else {
        modalTitle.classList.add('modal-title-error');
        modalMessage.classList.add('modal-error');
    }

    const modal = new bootstrap.Modal(document.getElementById('statusModal'));
    modal.show();
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

                // Verifique se result é um objeto JSON
                try {
                    if (typeof result === "string") {
                        result = JSON.parse(result); // Tente analisar se result é uma string
                    }
                } catch (e) {
                    console.error("Erro ao analisar JSON:", e);
                    $("#resultadoEmprestimos").append(
                        `<tr>
                    <td colspan="5">Erro ao processar os dados retornados.</td>
                </tr>`
                    );
                    return;
                }

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
                    <option value="5" ${emprestimo.status == 'Emprestado' ? 'selected' : ''}>Emprestado</option>
                    <option value="6" ${emprestimo.status == 'Devolvido' ? 'selected' : ''}>Devolvido</option>
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

// FUNÇÃO PARA ALTERAR ACESSO DE USUARIO
$(document).ready(function () {
    $('#form-alterar-acesso').on('submit', function (event) {
        event.preventDefault();

        $.ajax({
            url: 'http://localhost/projeto-biblioteca/private/controller/Admin.Controller.php',
            method: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function (data) {
                if (data.status) {
                    $('#resultado').html('<div class="alert alert-success">' + data.message + '</div>');
                } else {
                    $('#resultado').html('<div class="alert alert-danger">' + data.message + '</div>');
                }
            },
            error: function () {
                $('#resultado').html('<div class="alert alert-danger">Erro ao enviar a solicitação.</div>');
            },


        });
    });
});












































