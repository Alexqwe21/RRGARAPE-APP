<!DOCTYPE html>
<html lang="pt-br">

<?php require_once("templates/head.php") ?>

<body>

    <section class="app fundo_circulo_invertido espaco-menu">

        <div class="container_voltar">
            <a href="<?php echo BASE_URL_APP ?>index.php?url=home" class="voltar">
                <img src="<?php echo BASE_URL_APP ?>assets/img/seta_esquerda.svg" alt="seta esquerda"> Voltar
            </a>
            <img src="<?php echo BASE_URL_APP ?>assets/img/logo_pequeno.svg" alt="logo_pequeno">
        </div>

        <div class="bg-none">
            <h2 class="titulo">Meus Agendamentos</h2>
            <h2><?= count($agendamentos) ?></h2>
            <a href="<?= BASE_URL_APP ?>index.php?url=agendamentoApp" class="btn_app w-90">Novo Agendamento +</a>

            <div class="filtro-select w-90">
                <label for="filtroStatus">Filtrar por status:</label>
                <select class="filtros" id="filtroStatus">
                    <option value="todos">Todos</option>
                    <option value="Em análise">Em análise</option>
                    <option value="Agendado">Agendado</option>
                    <option value="Concluido">Concluído</option>
                    <option value="Cancelado">Cancelado</option>
                </select>
            </div>


            <?php if (!empty($agendamentos) && is_array($agendamentos)): ?>
                <div id="lista-agendamentos">
                    <?php foreach ($agendamentos as $agendamento): ?>

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

                        // Inclui o template do card
                        require("templates/card_agendamentos.php");
                        ?>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="ErroMensagem"><?= $mensagem ?></p>
            <?php endif; ?>
        </div>

        <?php require_once('templates/modal_cancelar.php') ?>
        <?php require_once('templates/modal_motivo.php') ?>

    </section>

    <?php require_once("templates/menuNav.php") ?>

    <script>
        function abrirModal(id) {
            document.getElementById("modalCancelar").classList.remove("hidden");
            document.getElementById('id_agendamento').value = id;

            // Atualiza a action do formulário com o ID na URL
            const form = document.getElementById("formCancelar");
            form.action = "<?= BASE_URL_APP ?>index.php?url=listarAgendamentos/cancelarAgendamento/" + id;
        }

        function fecharModal() {
            document.getElementById("modalCancelar").classList.add("hidden");
        }
    </script>

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

            document.querySelectorAll('.card2_container').forEach(card => {
                const statusCard = card.getAttribute('data-status');
                if (statusSelecionado === 'todos' || statusCard === statusSelecionado) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    </script>

<script>
    function abrirModal(id) {
        document.getElementById("modalCancelar").classList.remove("hidden");
        document.getElementById('id_agendamento').value = id;

        const form = document.getElementById("formCancelar");
        form.action = "<?= BASE_URL_APP ?>index.php?url=listarAgendamentos/cancelarAgendamento/" + id;
    }

    function fecharModal() {
        document.getElementById("modalCancelar").classList.add("hidden");
    }

    // MODAL MOTIVO
    function abrirModalMotivo(motivo) {
        document.getElementById("texto_motivo").textContent = motivo;
        document.getElementById("modal_motivo").classList.remove("hidden");
    }

    function fecharModalMotivo() {
        document.getElementById("modal_motivo").classList.add("hidden");
    }
</script>

<script>
    document.querySelectorAll('.menu_suspenso').forEach(menu => {
        const botao = menu.querySelector('.menu_botao');

        botao.addEventListener('click', (e) => {
            e.stopPropagation();
            document.querySelectorAll('.menu_suspenso').forEach(m => m.classList.remove('ativo'));
            menu.classList.toggle('ativo');
        });
    });

    window.addEventListener('click', () => {
        document.querySelectorAll('.menu_suspenso').forEach(m => m.classList.remove('ativo'));
    });
</script>



</body>

</html>