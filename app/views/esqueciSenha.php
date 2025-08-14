<!DOCTYPE html>
<html lang="pt-br">

<?php require_once("templates/head.php") ?>

<body>

    <section class="esqueciSenha app">
        <div class="container_voltar">
            <a href="<?php echo BASE_URL_APP ?>" class="voltar"> <img src="<?php echo BASE_URL_APP ?>assets/img/seta_esquerda.svg" alt="">Voltar</a>
        </div>

        <div class="logo_wave">
            <img src="<?php echo BASE_URL_APP ?>assets/img/logo_wave.svg" alt="logo_wave">
        </div>

        <div class="formulario">
            <h2>Informe seu E-mail</h2>

            <form action="<?= BASE_URL_APP ?>index.php?url=esqueciSenha/recuperarSenha" method="POST">

                <div class="input_grupo">

                    <!-- EMAIL -->
                    <label for="email">
                        <div><img src="<?php echo BASE_URL_APP ?>assets/img/email.svg" alt="email">Email:</div>
                        <input type="email" name="email_cliente" id="email" placeholder="exemplo@exemplo.com" required>
                    </label>

                    <!-- BOTÃO -->
                    <div class="button_senha">
                        <button class="btn_app" type="submit">Enviar Link de Recuperação</button>
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

    <script>
        // Mensagem de resposta da API
        document.addEventListener("DOMContentLoaded", function() {
            const msgBox = document.getElementById("msg-resposta");

            if (msgBox && msgBox.innerHTML.trim() !== "") {
                const isSucesso = msgBox.querySelector('.msg-sucesso') !== null;
                const isErro = msgBox.querySelector('.msg-erro') !== null;

                if (isSucesso) {
                    msgBox.classList.add('show-sucesso');
                } else if (isErro) {
                    msgBox.classList.add('show-erro');
                }

                // Oculta após 5 segundos
                setTimeout(() => {
                    msgBox.classList.remove('show-sucesso');
                    msgBox.classList.remove('show-erro');
                    msgBox.innerHTML = "";
                }, 5000);
            }
        });
    </script>

</body>

</html>