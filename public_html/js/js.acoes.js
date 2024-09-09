// evento para verificar se o usuario preencheu os campos de login ao tentar logar
document.getElementById('login-btn').addEventListener('click', function(event) {
    var email = document.getElementById('login-user').value;
    var senha = document.getElementById('password-user').value;

    // Verifica se os campos estão vazios
    if (email === "" || senha === "") {
        document.getElementById('modal-alert').style.display = 'block'; // Exibe o modal
    }
});

// Fecha o modal quando o botão de fechar (X) for clicado
document.querySelector('.close-btn').addEventListener('click', function() {
    document.getElementById('modal-alert').style.display = 'none'; // Fecha o modal
});

// Fecha o modal se o usuário clicar fora da caixa de conteúdo
window.onclick = function(event) {
    if (event.target === document.getElementById('modal-alert')) {
        document.getElementById('modal-alert').style.display = 'none'; // Fecha o modal
    }
};

