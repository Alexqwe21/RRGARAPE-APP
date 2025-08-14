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

        <h2 class="titulo">Meus Veículos</h2>
        <h2><?= count($veiculos) ?></h2>

        <a href="<?= BASE_URL_APP ?>index.php?url=cadVeiculo" class="btn_app w-90">Novo Veículo +</a>

        <div class="filtro-select w-90">
            <label for="filtroCategoria">Filtrar por categoria:</label>
            <select class="filtros" id="filtroCategoria">
                <option value="todos">Todos</option>
                <option value="Carro">Carro</option>
                <option value="Moto">Moto</option>
                <option value="Caminhão">Caminhão</option>
            </select>
        </div>

        <?php if (!empty($veiculos) && is_array($veiculos)): ?>
            <?php foreach ($veiculos as $veiculo): ?>
                <?php require('templates/card_veiculos.php'); ?>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="ErroMensagem">🙁 Ops! Nenhum veículo cadastrado ainda... Cadastre o seu para aproveitar todos os recursos! 🚗</p>
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
        document.getElementById('filtroCategoria').addEventListener('change', function() {
            const categoriaSelecionada = this.value;

            document.querySelectorAll('.card1_container').forEach(card => {
                const statusCard = card.getAttribute('data-categoria');
                if (categoriaSelecionada === 'todos' || statusCard === categoriaSelecionada) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    </script>

</body>



</html>