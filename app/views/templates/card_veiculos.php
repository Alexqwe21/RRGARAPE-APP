<?php
$linkBtn = "index.php?url=veiculos/detalhe/" . $veiculo['id_veiculo'];
$textoBtn = 'VER DETALHES';
?>

<div class="veiculos card1_container" data-categoria="<?= $veiculo['categoria_veiculo'] ?>">

    <div class="card1_header">
        <p><?= htmlspecialchars($veiculo['marca_veiculo'] . ' ' . $veiculo['modelo_veiculo'], ENT_QUOTES, 'UTF-8') ?></p>
    </div>

    <div class="card1_body <?= $bg ?? '' ?>">
        <div class="card1_info">
            <div>
                <p>Placa:
                    <span class="txtVerde">
                        <?= htmlspecialchars($veiculo['placa_veiculo'], ENT_QUOTES, 'UTF-8') ?>
                    </span>
                </p>
            </div>

            <div>
                <p>Cor:
                    <span class="txtVerde">
                        <?= htmlspecialchars($veiculo['cor_veiculo'], ENT_QUOTES, 'UTF-8') ?>
                    </span>
                </p>
            </div>


            <div>
                <p>Ano:
                    <span class="txtVerde">
                        <?= htmlspecialchars($veiculo['ano_veiculo'], ENT_QUOTES, 'UTF-8') ?>
                    </span>
                </p>
            </div>
        </div>
        <a href="<?= $linkBtn ?>" class="btn_app"><?= $textoBtn ?></a>
    </div>

</div>