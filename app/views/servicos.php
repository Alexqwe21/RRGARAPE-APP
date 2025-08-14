<style>
    .lity-iframe-container iframe {
        height: 700px !important;
    }

    .lity-iframe-container {
        overflow: visible !important;
    }

    .lity-container {
        max-width: 100% !important;
        /* 90% da largura da tela */
        max-height: 95% !important;
        /* 90% da altura da tela */
        width: 900px !important;
        /* largura fixa maior */
        height: 700px !important;
        /* altura fixa maior */
    }

    /* Ajustar o iframe para preencher o modal */
    .lity-iframe-wrapper iframe {
        width: 100% !important;
        height: 100% !important;
    }
</style>


<!DOCTYPE html>
<html lang="pt-br">

<?php require_once("templates/head.php") ?>

<body>

    <section class="servicos app fundo_circulo espaco-menu">
        <div class="container_voltar">
            <a href="<?php echo BASE_URL_APP ?>index.php?url=home" class="voltar">
                <img src="<?php echo BASE_URL_APP ?>assets/img/seta_esquerda.svg" alt="seta esquerda"> Voltar
            </a>
            <img src="<?php echo BASE_URL_APP ?>assets/img/logo_pequeno.svg" alt="logo_pequeno">
        </div>

        <h2>Serviços</h2>

        <h3>Veículos</h3>
        <div class="card_carrossel">
            <?php foreach ($servicos as $servico): ?>


                <?php
                $imagemPadrao = BASE_FOTO . '/galeria/sem_foto.png';

                // Verifica se existe uma imagem cadastrada para o cliente
                $fotoServico = !empty($servico['foto_galeria']) ?
                    BASE_FOTO . '/' . $servico['foto_galeria'] :
                    $imagemPadrao;
                ?>

              
                <?php if ($servico['tipo_servico'] === 'veiculo'): ?>
                    <div class="card">
                        <div class="card_foto">
                            <img src="<?= $fotoServico ?>" alt="<?= $alt_foto ?>">

                        </div>
                        <div class="card_text">
                            <h3><?= htmlspecialchars($servico['nome_servico'], ENT_QUOTES, 'UTF-8') ?></h3>
                            <p><?= htmlspecialchars(mb_strimwidth($servico['descricao_servico'], 0, 60, '...'), ENT_QUOTES, 'UTF-8') ?></p>
                            <a href="<?= BASE_URL_SITE . 'servicos/detalhe/' . $servico['link_servico'] . '?modal=1' ?>" data-lity class="btn_app saiba_mais">
                                Saiba Mais
                            </a>

                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>

        <h3>Tapeçaria:</h3>
        <div class="card_carrossel">
            <?php foreach ($servicos as $servico): ?>

                <?php
                // Caminho da imagem do serviço
                $caminhoArquivo = BASE_URL_SITE . "uploads/" . $servico['foto_galeria'];
                $img = BASE_URL_SITE . "uploads/galeria/sem_foto.png";
                $alt_foto = "imagem sem foto";

                if (!empty($servico['foto_galeria'])) {
                    $headers = @get_headers($caminhoArquivo);
                    if ($headers && strpos($headers[0], '200') !== false) {
                        $img = $caminhoArquivo;
                        $alt_foto = htmlspecialchars($servico['alt_galeria'], ENT_QUOTES, 'UTF-8');
                    }
                }
                ?>

                <?php if ($servico['tipo_servico'] === 'tapeçaria'): ?>
                    <div class="card">
                        <div class="card_foto">
                            <img src="<?= $img ?>" alt="<?= $alt_foto ?>">
                        </div>
                        <div class="card_text">
                            <h3><?= htmlspecialchars($servico['nome_servico'], ENT_QUOTES, 'UTF-8') ?></h3>
                            <p><?= htmlspecialchars(mb_strimwidth($servico['descricao_servico'], 0, 60, '...'), ENT_QUOTES, 'UTF-8') ?></p>
                            <a href="<?= BASE_URL_SITE . 'servicos/detalhe/' . $servico['link_servico'] . '?modal=1' ?>" data-lity class="btn_app saiba_mais">
                                Saiba Mais
                            </a>

                        </div>
                    </div>
                <?php endif; ?>

            <?php endforeach; ?>
        </div>

    </section>

    <?php require_once("templates/menuNav.php") ?>




    <link href="https://cdnjs.cloudflare.com/ajax/libs/lity/2.4.1/lity.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lity/2.4.1/lity.min.js"></script>





</body>



</html>