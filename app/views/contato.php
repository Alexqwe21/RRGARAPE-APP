<!DOCTYPE html>
<html lang="pt-br">

<?php require_once("templates/head.php") ?>

<body>

    <section class="contato app espaco-menu">

        <div class="container_voltar">
            <a href="<?php echo BASE_URL_APP ?>index.php?url=home" class="voltar"> <img src="<?php echo BASE_URL_APP ?>assets/img/seta_esquerda.svg" alt="">Voltar</a>
        </div>

        <div class="logo_wave">
            <img src="<?php echo BASE_URL_APP ?>assets/img/logo_wave.svg" alt="logo_wave">
        </div>

        <div id="loading" class="spinner-overlay">
            <div class="spinner"></div>
            <p class="loading-text">Aguarde, processando...</p>
        </div>

        <div class="formulario">

            <h2>Deixe sua mensagem</h2>

            <form id="formContato" action="<?= BASE_URL_APP ?>index.php?url=contato/enviarEmail" method="POST">

                <div class="input_grupo">

                    <!-- ASSUNTO -->
                    <label for="assunto">Assunto:
                        <input class="maiusculo" type="text" name="assunto" id="assunto" required>
                    </label>

                    <!-- MENSAGEM -->
                    <label for="mensagem">Mensagem:
                        <textarea name="mensagem" id="mensagem" required></textarea>
                    </label>

                    <!-- BOTÃO -->
                    <div class="button_entrar">
                        <button class="btn_app" type="submit">
                            ENTRE EM CONTATO
                            <img src="<?php echo BASE_URL_APP ?>assets/img/Aviao.svg" alt="ícone Avião">
                        </button>
                        <a id="btnWhatsapp" href="https://wa.me/5511964344919?text=" class="btn_app bgVerde">
                            WHATSAPP
                            <img src="<?php echo BASE_URL_APP ?>assets/img/whatsapp-logo_icon.svg" alt="ícone whatsapp" style="filter: invert(100%) sepia(100%) saturate(500%) hue-rotate(180deg);">
                        </a>
                    </div>

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

    <?php require_once("templates/menuNav.php") ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('formContato');
            const msgResposta = document.getElementById('msg-resposta');
            const btnWhatsapp = document.getElementById('btnWhatsapp');
            const loading = document.getElementById('loading');

            const assunto = document.getElementById('assunto');
            const mensagem = document.getElementById('mensagem');

            const campos = [{
                    campo: assunto,
                    nome: "Assunto"
                },
                {
                    campo: mensagem,
                    nome: "Mensagem"
                }
            ];

            function validarCampos(campos) {
                let valido = true;
                let primeiroErro = null;
                let mensagemErro = "";

                campos.forEach(item => item.campo.style.border = '');
                msgResposta.innerHTML = '';
                msgResposta.classList.remove('show-erro', 'show-sucesso');

                campos.forEach(item => {
                    if (item.campo.value.trim() === '') {
                        item.campo.style.border = '2px solid red';
                        if (!primeiroErro) {
                            primeiroErro = item.campo;
                            mensagemErro = `O campo <strong>${item.nome}</strong> é obrigatório.`;
                        }
                        valido = false;
                    }
                });

                if (!valido) {
                    if (primeiroErro) primeiroErro.focus();
                    msgResposta.classList.add('show-erro');
                    msgResposta.innerHTML = `<p class="msg-erro">${mensagemErro}</p>`;
                    setTimeout(() => {
                        msgResposta.innerHTML = "";
                        msgResposta.classList.remove('show-erro');
                    }, 5000);
                }

                return valido;
            }

            // Envio do formulário
            form.addEventListener('submit', function(event) {
                if (!validarCampos(campos)) {
                    event.preventDefault();
                } else {
                    if (loading) loading.style.display = 'flex';
                }
            });

            // Botão do WhatsApp
            btnWhatsapp.addEventListener('click', function(e) {
                if (!validarCampos(campos)) {
                    e.preventDefault();
                    return;
                }

                const texto = encodeURIComponent(`*Assunto:* ${assunto.value.trim()}\n*Mensagem:* ${mensagem.value.trim()}`);
                this.href = `https://wa.me/5511964344919?text=${texto}`;
            });

            // Após o carregamento, verifica se há mensagem da API
            if (msgResposta && msgResposta.innerHTML.trim() !== "") {
                const isSucesso = msgResposta.querySelector('.msg-sucesso') !== null;
                const isErro = msgResposta.querySelector('.msg-erro') !== null;

                if (isSucesso) {
                    msgResposta.classList.add('show-sucesso');
                } else if (isErro) {
                    msgResposta.classList.add('show-erro');
                }

                // Oculta loading e mensagem após 5 segundos
                setTimeout(() => {
                    msgResposta.classList.remove('show-sucesso', 'show-erro');
                    msgResposta.innerHTML = "";
                    if (loading) loading.style.display = 'none';
                }, 5000);
            } else {
                // Se não houver mensagem, oculta o loading imediatamente
                if (loading) loading.style.display = 'none';
            }
        });
    </script>

</body>

</html>