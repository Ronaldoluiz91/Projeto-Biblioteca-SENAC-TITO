// LOGIN
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
                    dataType: "json",
                    async: true,
                    data: {
                        email: email,
                        senha: senha,
                        fxLogin: fxLogin
                    }
                })

                    .done(function (result) {
                        console.log(result); // Verifica o resultado retornado
                        if (result['status']) {
                            $('#alertMsg').removeClass("error").html(result.msg).addClass("success");
                            // window.location.href = result.dashboardClient;
                            window.open(result.dashboard, '_blank');
                        } else {
                            $('#alertMsg').html(result.msg).addClass("error");
                        }
                    })

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



//--------------------------------------------------------------------------------------------------------------------------//
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
            const whatsapp = document.getElementById('whatsapp')?.value;
            const senha = document.getElementById('password')?.value;
            const confirmSenha = document.getElementById('confirm-password')?.value;
            const fxLogin = document.getElementById('fxLogin')?.value;

            if (!nome || !email || !cpf || !senha || !confirmSenha || !whatsapp) {
                showModal(); // Exibe o modal se houver campos vazios
            } else if (senha !== confirmSenha) {
                const modalContent = document.querySelector('.modal-content p');
                if (modalContent) {
                    modalContent.innerText = "As senhas não coincidem.";
                }
                showModal(); // Exibe o modal se as senhas não coincidem
            } else {
                // Envia os dados para o controller via AJAX
                $.ajax({
                    url: "http://localhost/projeto-biblioteca/private/controller/Login.controller.php",
                    method: "POST",
                    async: true,
                    dataType: 'json', // Força a resposta como JSON
                    data: {
                        nome: nome,
                        email: email,
                        whatsapp: whatsapp,
                        cpf: cpf,
                        senha: senha,
                        confirmSenha: confirmSenha,
                        fxLogin: fxLogin
                    }
                })
                .done(function (result) {
                    console.log(result); // Verifica se o result já é JSON
                    if (result.status) {
                        $('#alertMsg').removeClass("error");
                        $('#alertMsg').html(result.msg).addClass("success");
                    } else {
                        $('#alertMsg').html(result.msg).addClass("error");
                    }
                });
                

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


//-------------------- pagina recuperação de senha 

function recLogin() {
    var recLoginEmail = $('#login-user').val();
    var fxLogin = $('#fxLogin').val();

    if (!recLoginEmail) {
        $('#alertMsg').text('Por favor preencha o campo');
        $('#user-login-email').focus();
        return;
    }

    $.ajax({
        url: "http://localhost/projeto-biblioteca/private/controller/Login.controller.php",
        method: "POST",
        async: true,
        data: {
            recLoginEmail: recLoginEmail,
            fxLogin: fxLogin
        }
    })

        .done(function (result) {
            if (result['status']) {
                //document.getElementById("alertMsg").innerHTML = result.msg;
                $('#alertMsg').removeClass("error");
                $('#alertMsg').html(result.msg).addClass("success");
            } else {
                $('#alertMsg').removeClass("success");
                $('#alertMsg').html(result.msg).addClass("error");
            }
        })
}


//----------FUNÇÃO PARA NOVA SENHA-------------------------

function resetLogin() {
    $('#alertMsg').html('');

    let fxLogin = $('#fxLogin').val();
    let userLogin = $('#user-login').val();
    let userPassword = $('#user-password').val();
    let userConfirmPassword = $('#user-confirm-password').val();
    let idRec = $('#idRec').val();



    if ((!userLogin || !userPassword || !userConfirmPassword) || (!idRec)) {
        $('#alertMsg').html('<p>Usuário - Preencha o campo obrigatório!</p>');
        $('#alertMsg').addClass('error');
        $('#user-login-email').focus();
        return;
    }

    if( userPassword != userConfirmPassword){
        $('#alertMsg').html('<p>Usuário - As senhas não combinam!</p>');
        $('#alertMsg').addClass('error');
        return;
    }

    $.ajax({
        url: "http://localhost/projeto-biblioteca/private/controller/Login.controller.php",
        method: "POST",
        async: true,
        data: {
            fxLogin: fxLogin,
            userLogin: userLogin,
            userPassword: userPassword,
            userConfirmPassword: userConfirmPassword,
            idRec: idRec
        }
    })

        .done(function (result) {
            if (result['status']) {
                //document.getElementById("alertMsg").innerHTML = result.msg;
                $('#alertMsg').removeClass("error");
                $('#alertMsg').html(result.msg).addClass("success");
            } else {
                $('#alertMsg').removeClass("success");
                $('#alertMsg').html(result.msg).addClass("error");
            }
        })


}


