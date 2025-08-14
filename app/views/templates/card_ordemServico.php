<?php
// Valores padrão do botão do card
$linkBtn = "index.php?url=ordemServico/detalhe/" . $ordem['id_ordem_servico'];
$textoBtn = 'VER DETALHES';

// Verifica se a variável existe e se a página atual é home
if (isset($url) && $url === 'home') {
    $linkBtn = BASE_URL_APP . 'index.php?url=minhasOrdens';
    $textoBtn = 'VER TODAS AS ORDENS DE SERVIÇO';
    $bg = 'bg-black';
}
?>

<div class="card1_container" data-status="<?= $ordem['status_ordem'] ?>">

    <div class="card1_header">
        <p><?= htmlspecialchars($ordem['marca_veiculo'] . ' ' . $ordem['modelo_veiculo'], ENT_QUOTES, 'UTF-8') ?></p>
        <p><?= htmlspecialchars($ordem['placa_veiculo'], ENT_QUOTES, 'UTF-8') ?></p>
    </div>

    <div class="card1_body <?= $bg ?? '' ?>">
        <div class="card1_info">
            <p>Status:
                <span class="<?= $statusClass ?>">
                    <?= htmlspecialchars($ordem['status_ordem'], ENT_QUOTES, 'UTF-8') ?>
                </span>
            </p>
            <p>serviços:
                <span class="txtVerde">
                    <?= $ordem['quantidade_servicos'] ?>
                </span>
            </p>

            <p>Data abertura:
                <span class="txtVerde">
                    <?php
                    $data = new DateTime($ordem['data_abertura_ordem']);
                    echo $data->format('d/m/Y H:i');
                    ?>
                </span>
            </p>

            <?php if ($ordem['data_fechamento_ordem']): ?>
                <p>Data fechamento:
                    <span class="txtVerde">
                        <?php
                        $data = new DateTime($ordem['data_fechamento_ordem']);
                        echo $data->format('d/m/Y H:i');
                        ?>
                    </span>
                </p>
            <?php endif ?>
        </div>


    </div>

    <a href="<?= $linkBtn ?? '#' ?>" class="btn_app"><?= $textoBtn ?? 'Ver Detalhes' ?></a>

</div>