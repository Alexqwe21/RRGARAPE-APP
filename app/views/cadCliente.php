<!DOCTYPE html>
<html lang="pt-br">

<?php require_once("templates/head.php") ?>

<body>

    <section class="cadastro_cliente app fundo_circulo">

        <div class="container_voltar">
            <a href="<?php echo BASE_URL_APP ?>" class="voltar">
                <img src="<?php echo BASE_URL_APP ?>assets/img/seta_esquerda.svg" alt="seta esquerda"> Voltar
            </a>
            <img src="<?php echo BASE_URL_APP ?>assets/img/logo_pequeno.svg" alt="logo_pequeno">
        </div>

        <div class="formulario bg-none">
            <h2>Cadastre-se</h2>

            <form method="POST" action="<?= BASE_URL_APP ?>index.php?url=cadCliente/cadastrarCliente" id="form-cadastro" class="bg-none">
                <div class="input_grupo">

                    <!-- NOME -->
                    <label for="nome_cliente"> Nome Completo*:
                        <input class="maiusculo" type="text" name="nome_cliente" id="nome_cliente" required>
                    </label>

                    <!-- TELEFONE -->
                    <label for="telefone_cliente">Telefone*:
                        <input type="tel" id="telefone_cliente" name="telefone_cliente">
                    </label>

                    <!-- EMAIL -->
                    <label for="email_cliente">Email*:
                        <input type="email" name="email_cliente" id="email_cliente" required>
                    </label>

                    <!-- SENHA -->
                    <label for="senha_cliente">Senha*:
                        <div class="input-wrapper">
                            <input type="password" name="senha_cliente" id="senha_cliente" required placeholder="********" minlength="8">
                            <img src="<?php echo BASE_URL_APP ?>assets/img/olho_fechado.svg" alt="Ver senha" class="toggleSenha icone-senha">
                        </div>
                    </label>

                    <!-- CONFIRMAR SENHA -->
                    <label for="confirmarSenha">Confirmar senha*:
                        <div class="input-wrapper">
                            <input type="password" name="confirmarSenha" id="confirmarSenha" required placeholder="********" minlength="8">
                            <img src="<?php echo BASE_URL_APP ?>assets/img/olho_fechado.svg" alt="Ver confirmarSenha" class="toggleSenha icone-senha">
                        </div>
                    </label>

                    <button class="btn_app" type="submit">CADASTRAR</button>

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

    <script src="<?= BASE_URL_APP ?>assets/js/mascaras.js"></script>

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

        // Olho da senha
        const toggleSenha = document.querySelectorAll('.toggleSenha');
        toggleSenha.forEach((icone) => {
            icone.addEventListener('click', () => {
                const input = icone.previousElementSibling; // input está antes da imagem no DOM
                const estaVisivel = input.type === 'text';
                input.type = estaVisivel ? 'password' : 'text';

                // Troca o ícone do olho
                icone.src = estaVisivel ?
                    '<?php echo BASE_URL_APP ?>assets/img/olho_fechado.svg' :
                    '<?php echo BASE_URL_APP ?>assets/img/olho_aberto.svg';
            });
        });
    </script>

    <script>
        // Máscaras
        nome = document.getElementById('nome_cliente');
        telefone = document.getElementById('telefone_cliente');

        nome.addEventListener('input', function() {
            mascaraNome(this);
        })

        telefone.addEventListener('input', function() {
            mascaraTelefone(this);
        })

        document.getElementById("form-cadastro").addEventListener("submit", function(e) {
            e.preventDefault();

            const msgBox = document.getElementById("msg-resposta");
            const senha = document.getElementById("senha_cliente");
            const confirmSenha = document.getElementById("confirmarSenha");

            senha.classList.remove('erro-borda');
            confirmSenha.classList.remove('erro-borda');

            if (senha.value != confirmSenha.value) {
                msgBox.innerHTML = "As senhas não coincidem!";
                msgBox.classList.add('show-erro');
                // Oculta após 5 segundos
                setTimeout(() => {
                    msgBox.classList.remove('show-erro');
                    msgBox.innerHTML = "";
                }, 5000);

                senha.classList.add('erro-borda');
                confirmSenha.classList.add('erro-borda');
                senha.focus();
                return;
            }

            document.getElementById('form-cadastro').submit();

        });
    </script>

</body>

</html>