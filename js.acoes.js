document.addEventListener('DOMContentLoaded', function () {
    // Adiciona o evento de clique para o botão de login
    const loginBtn = document.getElementById('login-btn');
    if (loginBtn) {
        loginBtn.addEventListener('click', function () {
            const email = document.getElementById('login-user')?.value;
            const senha = document.getElementById('password-user')?.value;
            const fxLogin = document.getElementById('fxLogin')?.value;

            if (!email || !senha) {
                const modal = document.getElementById('modal-alert-login');
                if (modal) {
                    modal.style.display = 'block'; // Exibe o modal
                }
            } else {
                // Envia os dados para o controller via AJAX
                $.ajax({
                    url: "http://localhost/projeto-biblioteca/private/controller/Login.controller.php",
                    method: "POST",
                    async: true,
                    data: {
                        email: email,
                        senha: senha,
                        fxLogin: fxLogin
                    },
                    success: function (response) {
                        console.log("Login realizado com sucesso:", response);
                    },
                    error: function (xhr, status, error) {
                        console.error("Erro no login:", error);  // Aqui você obtém o erro específico
                        console.error("Status:", status);        // O status da requisição
                        console.error("Resposta do servidor:", xhr.responseText); // A resposta do servidor
                    }
                });

            }
        });
    };
    // Fecha o modal quando o botão de fechar (X) é clicado
    const closeBtnLogin = document.querySelector('.close-btn-login');
    if (closeBtnLogin) {
        closeBtnLogin.addEventListener('click', function () {
            const modal = document.getElementById('modal-alert-login');
            if (modal) {
                modal.style.display = 'none'; // Fecha o modal
            }
        });
    }

    // Fecha o modal se o usuário clicar fora do conteúdo do modal
    window.onclick = function (event) {
        const modal = document.getElementById('modal-alert-login');
        if (modal && event.target === modal) {
            modal.style.display = 'none'; // Fecha o modal
        }
    };
});



// Verificação da pagina cadastro
document.addEventListener('DOMContentLoaded', function () {
    // Função para exibir o modal
    function showModal() {
        const modal = document.getElementById('modal-alert');
        if (modal) {
            modal.style.display = 'block';
        }
    }

    // Função para fechar o modal
    function closeModal() {
        const modal = document.getElementById('modal-alert');
        if (modal) {
            modal.style.display = 'none';
        }
    }



    // Verificação dos campos ao clicar no botão "Cadastrar-se"
    const cadBtn = document.getElementById('cad-btn');
    if (cadBtn) {
        cadBtn.addEventListener('click', function () {
            const nome = document.getElementById('name')?.value;
            const email = document.getElementById('email')?.value;
            const cpf = document.getElementById('cpf')?.value;
            const senha = document.getElementById('password')?.value;
            const confirmSenha = document.getElementById('confirm-password')?.value;
            const fxLogin = document.getElementById('fxLogin')?.value;

            if (!nome || !email || !cpf || !senha || !confirmSenha) {
                showModal(); // Exibe o modal se houver campos vazios
            } else if (senha !== confirmSenha) {
                const modalContent = document.querySelector('.modal-content p');
                if (modalContent) {
                    modalContent.innerText = "As senhas não coincidem.";
                }
                showModal(); // Exibe o modal se as senhas não coincidem
            } else {
                alert("Cadastro realizado com sucesso!"); // Mensagem de sucesso
                // Envia os dados para o controller via AJAX
                $.ajax({
                    url: "http://localhost/projeto-biblioteca/private/controller/Login.controller.php",
                    method: "POST",
                    async: true,
                    data: {
                        nome: nome,
                        email: email,
                        cpf: cpf,
                        senha: senha,
                        confirmSenha: confirmSenha,
                        fxLogin: fxLogin

                    }
                })

                    .done(function (result) {
                        if (result['status']) {
                            // document.getElementById("alertMsg").innerHTML = result.msg;
                            $('#alertMsg').removeClass("error");
                            $('#alertMsg').html(result.msg).addClass("sucess");
                        } else {
                            $('#alertMsg').html(result.msg).addClass("error");

                        }
                    })

            }
        });
    }

    // Fecha o modal quando o botão de fechar (X) é clicado
    const closeBtn = document.querySelector('.close-btn');
    if (closeBtn) {
        closeBtn.addEventListener('click', closeModal);
    }

    // Fecha o modal ao clicar fora do conteúdo do modal
    window.onclick = function (event) {
        const modal = document.getElementById('modal-alert');
        if (modal && event.target === modal) {
            closeModal();
        }
    };
});


