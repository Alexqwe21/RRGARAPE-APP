<!DOCTYPE html>
<html lang="pt-BR">

<?php require_once("templates/head.php") ?>

<body>

    <section class="chatContainer app espaco-menu">

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

        <div class="inputUser" id="inputUserContainer">
            <input type="text" id="userInput" placeholder="Digite aqui..." autofocus />
            <button class="btn_chat" id="btnEnviar">
                <img src="<?php echo BASE_URL_APP ?>assets/img/Aviao.svg" alt="Aviao">
            </button>
        </div>

        <!-- Agendamento: aparece depois -->
        <div id="agendamentoSection">
            <!-- <h3>Selecione o dia e horário para o agendamento:</h3> -->
            <form id="formAgendamento">
                <div class="dias" id="diasContainer"></div>
                <div class="horarios" id="horariosContainer"></div>
                <!-- <br /> -->
                <button class="btn_app w-90" type="submit">Confirmar Agendamento</button>
            </form>
        </div>

    </section>

    <script src="<?= BASE_URL_APP ?>assets/js/mascaras.js"></script>

    <script>
        const idCliente = null;
        const token = null;
    </script>
    <script src="<?= BASE_URL_APP ?>assets/js/agendamento.js"></script>

</body>

</html>