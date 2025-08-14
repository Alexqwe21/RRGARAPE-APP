<!DOCTYPE html>
<html lang="pt-br">

<?php require_once("templates/head.php") ?>

<body>
    <section class="login app">

        <div class="logo_wave">
            <img src="<?php echo BASE_URL_APP ?>assets/img/logo_wave.svg" alt="logo_wave">
        </div>

        <div class="formulario">
            <h2>Login</h2>
            <form id="form-login">

                <div class="input_grupo">

                    <label for="email">
                        <div><img src="<?php echo BASE_URL_APP ?>assets/img/email.svg" alt="email">Email:</div>
                        <input type="email" name="email" id="email" required placeholder="exemplo@exemplo.com">
                    </label>

                    <label for="senha" class="cadeado">
                        <div><img src="<?php echo BASE_URL_APP ?>assets/img/cadeado.svg" alt="cadeado">Senha:</div>
                        <div class="input-wrapper">
                            <input type="password" name="senha" id="senha" required placeholder="********">
                            <img src="<?php echo BASE_URL_APP ?>assets/img/olho_fechado.svg" alt="Ver senha" id="toggleSenha" class="icone-senha">
                        </div>
                    </label>

                    <p>Esqueceu sua senha? <a href="<?php echo BASE_URL_APP ?>index.php?url=esqueciSenha">Clique Aqui!</a></p>

                    <button class="btn_app" type="submit">Entrar</button>

                    <p>Não possui uma conta? <a href="<?php echo BASE_URL_APP ?>index.php?url=cadCliente">Cadastre-se</a></p>

                </div>

            </form>

            <div id="msg-resposta" class="msg-resposta">
                <?php
                if (isset($_SESSION['msg-sucesso'])) {
                    echo '<p class="msg-sucesso">' . $_SESSION['msg-sucesso'] . '</p>';
                    unset($_SESSION['msg-sucesso']);
                }

                if (isset($_SESSION['msg-erro'])) {
                    echo '<p class="msg-erro">' . $_SESSION['msg-erro'] . '</p>';
                    unset($_SESSION['msg-erro']);
                }
                ?>
            </div>

        </div>

    </section>

    <div id="instalarContainer">
        <span>Deseja instalar o app?</span>
        <div>
            <button id="btnInstalar">Instalar</button>
            <button id="fecharInstalar">Não</button>
        </div>
    </div>

    <script>
        let deferredPrompt;
        const container = document.getElementById('instalarContainer');
        const btnInstalar = document.getElementById('btnInstalar');
        const fecharInstalar = document.getElementById('fecharInstalar');

        // Evento de prompt de instalação
        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            deferredPrompt = e;
            container.style.display = 'block';

            btnInstalar.addEventListener('click', async () => {
                container.style.display = 'none';
                deferredPrompt.prompt();

                const {
                    outcome
                } = await deferredPrompt.userChoice;
                console.log(`Instalação: ${outcome}`);
                deferredPrompt = null;
            });
        });

        fecharInstalar.addEventListener('click', () => {
            container.style.display = 'none';
        });

        // Registrar o Service Worker
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('service_worker.js')
                    .then(function(registration) {
                        console.log('ServiceWorker registrado com sucesso:', registration.scope);
                    })
                    .catch(function(error) {
                        console.log('Falha ao registrar o ServiceWorker:', error);
                    });
            });
        }
    </script>

    <script>
        // Detectar se o app está no modo standalone (já instalado)
        const isInStandaloneMode = () => ('standalone' in window.navigator) && window.navigator.standalone;

        // Detectar se é iOS
        const isIos = () => {
            const userAgent = window.navigator.userAgent.toLowerCase();
            return /iphone|ipad|ipod/.test(userAgent);
        }

        // Mostrar instrução se for iOS e ainda não tiver adicionado à tela inicial
        window.addEventListener('load', () => {
            if (isIos() && !isInStandaloneMode()) {
                // Verifica se já mostrou a instrução antes
                if (!localStorage.getItem('ios-pwa-instruction-shown')) {
                    const banner = document.createElement('div');
                    banner.innerHTML = `
        <div style="position:fixed; bottom:10px; left:10px; right:10px; background:#F9F9F9; border:1px solid #ccc; padding:15px; border-radius:10px; box-shadow:0 0 10px rgba(0,0,0,0.2); font-family:sans-serif; z-index:9999;">
          <span style="font-size:20px;">📱</span> No Safari é preciso em <strong>“Adicionar à Tela de Início”</strong> no menu de compartilhamento
          <button onclick="this.parentElement.remove();" style="float:right; background:#007aff; color:white; border:none; padding:5px 10px; border-radius:5px;">OK</button>
        </div>
      `;
                    document.body.appendChild(banner);
                    // Salvar no localStorage para não mostrar novamente
                    // localStorage.setItem('ios-pwa-instruction-shown', 'true');
                }
            }
        });
    </script>

    <script>
        // Olho da senha
        const senhaInput = document.getElementById('senha');
        const toggleSenha = document.getElementById('toggleSenha');

        toggleSenha.addEventListener('click', () => {
            const estaVisivel = senhaInput.type === 'text';
            senhaInput.type = estaVisivel ? 'password' : 'text';

            // Troca o ícone do olho
            toggleSenha.src = estaVisivel ? 'assets/img/olho_fechado.svg' : 'assets/img/olho_aberto.svg';
        });
    </script>

    <script>
        document.getElementById("form-login").addEventListener("submit", function(e) {
            e.preventDefault();

            fecharTeclado(); // <- força o teclado do celular a fechar

            const email = document.getElementById("email").value;
            const senha = document.getElementById("senha").value;

            fetch("<?php echo BASE_URL_APP; ?>index.php?url=login/autenticar", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    body: `email=${encodeURIComponent(email)}&senha=${encodeURIComponent(senha)}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.sucesso) {
                        window.location.href = "<?php echo BASE_URL_APP; ?>index.php?url=home";
                    } else {
                        mostrarMensagemErro(data.mensagem || "Email ou senha inválidos!");
                    }
                })
                .catch(error => {
                    console.error("Erro ao autenticar:", error);
                    mostrarMensagemErro("Erro de conexão com o servidor.");
                });

            function mostrarMensagemErro(msg) {
                const divErro = document.getElementById("msg-resposta");
                console.log(window.innerHeight);
                divErro.textContent = msg;
                divErro.classList.add("show-erro");

                setTimeout(() => {
                    divErro.classList.remove("show-erro");
                }, 4000); // desaparece após 4 segundos
            }

            // Tira o foco do input e fecha o teclado do celular automaticamente
            function fecharTeclado() {
                if (document.activeElement && document.activeElement.blur) {
                    document.activeElement.blur();
                }
            }
        });
    </script>

</body>

</html>