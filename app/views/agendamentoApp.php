<!DOCTYPE html>
<html lang="pt-BR">

<?php require_once("templates/head.php") ?>

<body>
    <!-- Menu do app -->
    <?php require_once("templates/menuNav.php") ?>

    <main>
        <section class="chatContainer app">

            <div class="logo_wave">
                <img src="<?php echo BASE_URL_APP ?>assets/img/logo_wave.svg" alt="logo_wave">
            </div>

            <div id="chat">
                <div class="bot">Olá! Vamos fazer seu agendamento. 😊</div>
            </div>

            <div id="loading" class="spinner-overlay">
                <div class="spinner"></div>
                <p class="loading-text">Aguarde, processando...</p>
            </div>

            <div id="agendamentoSection">
                <form id="formAgendamento" method="POST" action="<?= BASE_API ?>">
                    <div class="dias" id="diasContainer"></div>
                    <div class="horarios" id="horariosContainer"></div>
                    <br />
                    <button class="btn_app w-90" type="submit">Confirmar Agendamento</button>
                    <a href="<?= BASE_URL_APP ?>index.php?url=listarAgendamentos" class="btn_app w-90 btn_cancelar">Cancelar</a>
                </form>
            </div>

        </section>
    </main>

    <script src="<?= BASE_URL_APP ?>assets/js/mascaras.js"></script>

    <script>
        const idCliente = <?= json_encode($id_cliente ?? null) ?>;
        const token = <?= json_encode($_SESSION['token'] ?? null) ?>;
    </script>
    <script src="<?= BASE_URL_APP ?>assets/js/agendamento.js"></script>

</body>

</html>