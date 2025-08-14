<!DOCTYPE html>
<html lang="pt-br">

<?php require_once("templates/head.php") ?>

<body>

    <section class="minhas_ordens app fundo_circulo_invertido espaco-menu">

        <div class="container_voltar">
            <a href="<?= BASE_URL_APP ?>index.php?url=home" class="voltar">
                <img src="<?= BASE_URL_APP ?>assets/img/seta_esquerda.svg" alt="seta esquerda"> Voltar
            </a>
            <img src="<?= BASE_URL_APP ?>assets/img/logo_pequeno.svg" alt="logo_pequeno">
        </div>

        <h2 class="titulo">Ordens de Serviço</h2>
        <h2><?= count($ordens) ?></h2>

        <div class="filtro-select w-90">
            <label for="filtroStatus">Filtrar por status:</label>
            <select class="filtros" id="filtroStatus">
                <option value="todos">Todos</option>
                <option value="Fechada">Fechada</option>
                <option value="Aberta">Aberta</option>
                <option value="Cancelado">Cancelado</option>
            </select>
        </div>

        <?php if (!empty($ordens) && is_array($ordens)): ?>
            <?php foreach ($ordens as $ordem): ?>
                <?php
                // Define classe para status
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

                // Caminho para o card visual
                require('templates/card_ordemServico.php');
                ?>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="ErroMensagem"><?= $mensagemOrdem ?></p>
            <a href="<?= BASE_URL_APP . 'index.php?url=agendamentoApp' ?>" class="btn_app w-90">Agendar</a>
        <?php endif; ?>


    </section>

    <?php require_once("templates/menuNav.php") ?>

    <script>
        document.querySelectorAll('.menu_suspenso').forEach(menu => {
            const botao = menu.querySelector('.menu_botao');

            botao.addEventListener('click', (e) => {
                e.stopPropagation(); // Evita que o clique feche imediatamente
                document.querySelectorAll('.menu_suspenso').forEach(m => m.classList.remove('ativo')); // Fecha outros
                menu.classList.toggle('ativo'); // Abre este
            });
        });

        // Fecha todos ao clicar fora
        window.addEventListener('click', () => {
            document.querySelectorAll('.menu_suspenso').forEach(m => m.classList.remove('ativo'));
        });
    </script>

    <script>
        document.getElementById('filtroStatus').addEventListener('change', function() {
            const statusSelecionado = this.value;

            document.querySelectorAll('.card1_container').forEach(card => {
                const statusCard = card.getAttribute('data-status');
                if (statusSelecionado === 'todos' || statusCard === statusSelecionado) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    </script>

</body>

</html>