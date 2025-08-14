<?php $totalServicos = count($servExecutados); ?>

<div class="card_carrossel <?= $totalServicos === 1 ? 'centralizar' : '' ?>">

    <?php foreach ($servExecutados as $serv): ?>
        <?php
        $caminhoArquivo = BASE_URL_SITE . "uploads/" . $serv['foto_galeria'];
        $img = BASE_URL_SITE . "uploads/galeria/sem_foto.png";
        $alt_foto = "imagem sem foto";

        if (!empty($serv['foto_galeria'])) {
            $headers = @get_headers($caminhoArquivo);
            if ($headers && strpos($headers[0], '200') !== false) {
                $img = $caminhoArquivo;
                $alt_foto = htmlspecialchars($serv['alt_galeria'], ENT_QUOTES, 'UTF-8');
            }
        }
        ?>

        <div class="card">
            <div class="card_foto">
                <img src="<?= $img ?>" alt="<?= $alt_foto ?>">
            </div>
            <div class="card_text">
                <h3><?= htmlspecialchars($serv['nome_servico'], ENT_QUOTES, 'UTF-8') ?></h3>
                <p><?= htmlspecialchars(mb_strimwidth($serv['descricao_servico'], 0, 60, '...'), ENT_QUOTES, 'UTF-8') ?></p>
            </div>
        </div>
    <?php endforeach; ?>
</div>