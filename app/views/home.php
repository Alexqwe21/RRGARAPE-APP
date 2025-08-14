<!DOCTYPE html>
<html lang="pt-br">

<?php
$extra_head = '
  <link rel="stylesheet" href="' . BASE_URL_APP . 'vendor/slick/slick.css">
  <link rel="stylesheet" href="' . BASE_URL_APP . 'vendor/slick/slick-theme.css">
';
require_once("templates/head.php");
?>

<body>
    <!-- Menu do app -->
    <?php require_once("templates/menuNav.php") ?>

    <section class="home app espaco-menu">

        <!-- FOTO DO CLIENTE -->
        <?php
        $caminhoArquivo = BASE_URL_SITE . "uploads/" . $cliente['foto_cliente'];
        $img = BASE_URL_SITE . "/uploads/galeria/sem_foto.png";
        $alt_foto = "imagem sem foto";

        if (!empty($cliente['foto_cliente'])) {
            $headers = @get_headers($caminhoArquivo);
            if ($headers && strpos($headers[0], '200') !== false) {
                $img = $caminhoArquivo;
                $alt_foto = !empty($cliente['alt_cliente']) ? htmlspecialchars($cliente['alt_cliente'], ENT_QUOTES, 'UTF-8') : 'Foto Perfil';
            }
        }
        ?>

        <div class="logo_wave">
            <img src="<?php echo BASE_URL_APP ?>assets/img/fundo_wave.svg" alt="fundo espadas">

            <div class="foto_cliente">
                <a href="<?= BASE_URL_APP ?>index.php?url=perfil">
                    <img src="<?= $img ?>" alt="<?= $alt_foto ?>">
                </a>
            </div>
        </div>

        <div id="loading" class="spinner-overlay">
            <div class="spinner"></div>
            <p class="loading-text">Aguarde, processando...</p>
        </div>

        <div class="fundo_conteudo">

            <!-- Nome do cliente -->
            <h2 class="titulo">
                Olá,
                <?php
                // Restaga o primeiro nome do cliente
                $primeiroNome = explode(' ', trim($cliente['nome_cliente']))[0];
                echo htmlspecialchars($primeiroNome, ENT_QUOTES, 'UTF-8');
                ?>
            </h2>

            <!-- Carrossel banner -->
            <section class="banner">
                <?php foreach ($dados['banner'] as $banner): ?>
                    <?php
                    $imgDefault = BASE_URL_SITE . "/uploads/galeria/sem_foto.png";
                    $caminhoImagem = BASE_URL_SITE . "uploads/" . $banner['foto_banner'];
                    $altImagem = "Imagem sem descrição";

                    if (!empty($banner['foto_banner'])) {
                        $headers = @get_headers($caminhoImagem);
                        if ($headers && strpos($headers[0], '200') !== false) {
                            $img = $caminhoImagem;
                            $altImagem = htmlspecialchars($banner['alt_banner'], ENT_QUOTES, 'UTF-8');
                        } else {
                            $img = $imgDefault;
                        }
                    } else {
                        $img = $imgDefault;
                    }
                    ?>
                    <div>
                        <img src="<?= $img ?>" alt="<?= $altImagem ?>">
                    </div>
                <?php endforeach; ?>
            </section>

            <!-- Ordem de serviço -->
            <section>
                <h3>Acompanhamento</h3>

                <?php if (!empty($ordens) && is_array($ordens)): ?>
                    <?php foreach ($ordens as $ordem): ?>
                        <?php
                        // Define a classe CSS de acordo com o status
                        $statusClass = '';
                        switch ($ordem['status_ordem']) {
                            case 'Cancelado':
                                $statusClass = 'txtVermelho';
                                break;
                            case 'Aberta':
                                $statusClass = 'txtAzul';
                                break;
                            case 'Fechada':
                                $statusClass = 'txtVerde';
                                break;
                        }
                        require('templates/card_ordemServico.php');
                        ?>
                    <?php endforeach; ?>
                <?php elseif (!empty($mensagemOrdem)): ?>
                    <p class="ErroMensagem w-90"><?= htmlspecialchars($mensagemOrdem) ?></p>
                    <a href="<?= BASE_URL_APP . 'index.php?url=minhasOrdens' ?>" class="btn_app w-90">VER TODAS ORDENS DE SERVIÇO</a>
                <?php endif; ?>

            </section>

            <!-- MODAL CANCELAR AGENDAMENTO -->
            <?php require_once('templates/modal_cancelar.php'); ?>

            <!-- Próximo Agendamento -->
            <section class="proxAgendamento">
                <h3>Próximo Agendamento</h3>

                <?php if (!empty($agendamento) && is_array($agendamento)): ?>
                    <?php
                    // Define classe para status
                    $statusClass = '';
                    switch ($agendamento['status_agendamento']) {
                        case 'Em análise':
                            $statusClass = 'txtAmarelo';
                            break;
                        case 'Agendado':
                            $statusClass = 'txtVerde';
                            break;
                        case 'Concluido':
                            $statusClass = 'txtAzul';
                            break;
                        case 'Cancelado':
                            $statusClass = 'txtVermelho';
                            break;
                    }

                    require("templates/card_agendamentos.php"); ?>

                <?php elseif (!empty($mensagemAgenda)): ?>
                    <p class="ErroMensagem w-90"><?= htmlspecialchars($mensagemAgenda) ?></p>
                <?php endif; ?>

                <a href="<?= BASE_URL_APP . 'index.php?url=listarAgendamentos' ?>" class="btn_app w-90">Ver Todos Agendamentos</a>

            </section>

            <!-- Newsletter -->
            <section>
                <h3>Newsletter</h3>
                <?php require_once('templates/card_newsletter.php') ?>
            </section>

            <!-- Depoimento -->
            <section>
                <?php require_once('templates/card_avaliar.php') ?>
            </section>

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

    <!-- SLICK JS -->
    <script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script type="text/javascript" src="<?= BASE_URL_APP ?>vendor/slick/slick.min.js"></script>

    <!-- Carrossel Banner -->
    <script type="text/javascript">
        $(document).ready(function() {
            $('.banner').slick({
                dots: true,
                arrows: false,
                infinite: true,
                speed: 500,
                fade: true,
                autoplay: true,
                autoplaySpeed: 3000,
                cssEase: 'linear'
            });
        });
    </script>

    <!-- Modal cancelar agendamento -->
    <script>
        function abrirModal(id) {
            document.getElementById("modalCancelar").classList.remove("hidden");
            document.getElementById('id_agendamento').value = id;

            // Atualiza a action do formulário com o ID na URL
            const form = document.getElementById("formCancelar");
            form.action = "<?= BASE_URL_APP ?>index.php?url=home/cancelarAgendamento/" + id;
        }

        function fecharModal() {
            document.getElementById("modalCancelar").classList.add("hidden");
        }
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.getElementById("formDepoimento");
            const descricao = document.getElementById("descricao_depoimento");
            const nota = document.getElementById("nota_depoimento");
            const msgResposta = document.getElementById("msg-resposta");
            const loading = document.getElementById("loading");
            const formNewsletter = document.getElementById("formNewsletter");

            // Validação do formulário de depoimento
            if (form) {
                form.addEventListener("submit", function(event) {
                    let valido = true;
                    let primeiroErro = null;
                    let mensagemErro = "";

                    descricao.style.border = "";
                    msgResposta.innerHTML = "";
                    msgResposta.classList.remove("show-erro", "show-sucesso");

                    if (!nota.value || parseInt(nota.value) < 1 || parseInt(nota.value) > 5) {
                        valido = false;
                        mensagemErro = "Por favor, selecione uma avaliação.";
                    }

                    if (descricao.value.trim() === "") {
                        descricao.style.border = "2px solid red";
                        if (!mensagemErro) mensagemErro = "Por favor, escreva um comentário.";
                        if (!primeiroErro) primeiroErro = descricao;
                        valido = false;
                    }

                    if (!valido) {
                        event.preventDefault();
                        msgResposta.classList.add("show-erro");
                        msgResposta.innerHTML = `<p class="msg-erro">${mensagemErro}</p>`;
                        if (primeiroErro) primeiroErro.focus();

                        setTimeout(() => {
                            msgResposta.innerHTML = "";
                            msgResposta.classList.remove("show-erro");
                        }, 5000);
                    } else {
                        if (loading) loading.style.display = "flex";
                    }
                });
            }

            //Controla envio do formulário de newsletter
            if (formNewsletter) {
                formNewsletter.addEventListener("submit", function() {
                    if (loading) loading.style.display = "flex";
                });
            }

            // Apresenta mensagem da API ao carregar (sucesso ou erro)
            if (msgResposta && msgResposta.innerHTML.trim() !== "") {
                const isSucesso = msgResposta.querySelector('.msg-sucesso') !== null;
                const isErro = msgResposta.querySelector('.msg-erro') !== null;

                msgResposta.classList.add(isSucesso ? 'show-sucesso' : 'show-erro');

                setTimeout(() => {
                    msgResposta.classList.remove('show-sucesso', 'show-erro');
                    msgResposta.innerHTML = "";
                    if (loading) loading.style.display = "none";
                }, 5000);
            } else {
                if (loading) loading.style.display = "none";
            }
        });
    </script>

</body>

</html>