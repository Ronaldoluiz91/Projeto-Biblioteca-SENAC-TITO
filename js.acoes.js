
// evento para verificar se o usuario preencheu os campos de login ao tentar logar
document.getElementById('login-btn').addEventListener('click', function(event) {
    var email = document.getElementById('login-user').value;
    var senha = document.getElementById('password-user').value;

    // Verifica se os campos estão vazios
    if (email === "" || senha === "") {
        document.getElementById('modal-alert-login').style.display = 'block'; // Exibe o modal
    }
});

// Fecha o modal quando o botão de fechar (X) for clicado
document.querySelector('.close-btn-login').addEventListener('click', function() {
    document.getElementById('modal-alert-login').style.display = 'none'; // Fecha o modal
});

// Fecha o modal se o usuário clicar fora da caixa de conteúdo
window.onclick = function(event) {
    if (event.target === document.getElementById('modal-alert-login')) {
        document.getElementById('modal-alert-login').style.display = 'none'; // Fecha o modal
    }
};






//Modal da pagina de cadastro


document.addEventListener('DOMContentLoaded', function() {
    // Função para exibir o modal
    function showModal() {
        document.getElementById('modal-alert').style.display = 'block';
    }

    // Função para fechar o modal
    function closeModal() {
        document.getElementById('modal-alert').style.display = 'none';
    }

    // Verificação dos campos ao clicar no botão "Cadastrar-se"
    document.getElementById('register-btn').addEventListener('click', function() {
        var nome = document.getElementById('name').value;
        var email = document.getElementById('email').value;
        var cpf = document.getElementById('cpf').value;
        var senha = document.getElementById('password').value;
        var confirmSenha = document.getElementById('confirm-password').value;

        // Verifica se todos os campos estão preenchidos
        if (nome === "" || email === "" || cpf === "" || senha === "" || confirmSenha === "") {
            showModal(); // Exibe o modal se houver campos vazios
        } else if (senha !== confirmSenha) {
            document.querySelector('.modal-content p').innerText = "As senhas não coincidem.";
            showModal(); // Exibe o modal se as senhas não coincidem
        } else {
            // Aqui você pode adicionar a lógica de envio do formulário
            alert("Cadastro realizado com sucesso!"); // Exemplo de mensagem de sucesso
        }
    });

    // Fechar o modal quando o botão de fechar (X) for clicado
    document.querySelector('.close-btn').addEventListener('click', closeModal);

    // Fechar o modal ao clicar fora do conteúdo do modal
    window.onclick = function(event) {
        if (event.target === document.getElementById('modal-alert')) {
            closeModal();
        }
    };
});
