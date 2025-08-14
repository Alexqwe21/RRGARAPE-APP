<?php
// Verifica se a variável existe e se a página atual é home
if (isset($url) && $url === 'home') {
    $bg = 'bg-black';
}
?>

<div class="card2_container_avaliar <?= $bg ?? '' ?>">

    <div class="card2_body">
        <div class="texto_topo">
            <p>Avaliar experiência</p>
            <span>O que você achou da experiência do
                nosso atendimento?</span>
        </div>

        <div>
            <form id="formDepoimento" method="POST" action="<?= BASE_URL_APP ?>index.php?url=home/cadastrarDepoimento" class="form_box container">

                <div class="input_group">

                    <div class="stars">
                        <span class="star" data-value="1"><img src="<?php echo BASE_URL_APP ?>assets/img/emoji_muitoRuim.svg" alt="Muito Ruim"></span>
                        <span class="star" data-value="2"><img src="<?php echo BASE_URL_APP ?>assets/img/ruim.svg" alt="Ruim"></span>
                        <span class="star" data-value="3"><img src="<?php echo BASE_URL_APP ?>assets/img/regular.svg" alt="Regular"></span>
                        <span class="star" data-value="4"><img src="<?php echo BASE_URL_APP ?>assets/img/bom.svg" alt="Bom"></span>
                        <span class="star" data-value="5"><img src="<?php echo BASE_URL_APP ?>assets/img/MuitoBom.svg" alt="Muito Bom"></span>
                    </div>
                    <label for="descricao_depoimento"></label>
                    <input type="text" name="descricao_depoimento" id="descricao_depoimento" required placeholder="Quer fazer um comentário?">

                    <!-- Input escondido para armazenar a nota do depoimento -->
                    <input type="hidden" name="nota_depoimento" id="nota_depoimento" value="">
                
                </div>

                <button type="submit" class="btn_app">ENVIAR DEPOIMENTO</button>
            </form>
        </div>

    </div>

</div>

<script>
    const stars = document.querySelectorAll('.stars .star');
    const notaInput = document.getElementById('nota_depoimento');

    stars.forEach(star => {
        star.addEventListener('click', () => {
            // Remove a classe 'selected' de todas as estrelas
            stars.forEach(s => s.classList.remove('selected'));

            // Adiciona 'selected' só na estrela clicada
            star.classList.add('selected');

            // Pega o valor da estrela clicada e coloca no input escondido
            const valor = star.getAttribute('data-value');
            notaInput.value = valor;
        });
    });
</script>