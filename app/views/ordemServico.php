<!DOCTYPE html>
<html lang="pt-br">

<?php require_once("templates/head.php") ?>

<body>

  <section class="ordem_servico app fundo_circulo_invertido espaco-menu">


    <div class="container_voltar">
      <a href="<?php echo BASE_URL_APP ?>index.php?url=minhasOrdens" class="voltar">
        <img src="<?php echo BASE_URL_APP ?>assets/img/seta_esquerda.svg" alt="seta esquerda"> Voltar
      </a>
      <img src="<?php echo BASE_URL_APP ?>assets/img/logo_pequeno.svg" alt="logo_pequeno">
    </div>

    <h2 class="titulo">Foto antes e depois</h2>

    <div class="card_carrossel_ordem_servico">

      <?php
      // Caminho da imagem padrão
      $imagemPadrao = BASE_FOTO . '/galeria/sem_foto.png';

      // --- FOTO ANTES ---
      $altAntes = "Imagem do veículo antes";
      // Verifica se existe uma imagem cadastrada
      $imgAntes = !empty($ordemServico['foto_antes_veiculo']) ?
        BASE_FOTO . '/' . $ordemServico['foto_antes_veiculo'] :
        $imagemPadrao;

      // --- FOTO DEPOIS ---
      $altDepois = "Imagem do veículo antes";
      // Verifica se existe uma imagem cadastrada
      $imgDepois = !empty($ordemServico['foto_depois_veiculo']) ?
        BASE_FOTO . '/' . $ordemServico['foto_depois_veiculo'] :
        $imagemPadrao;
      ?>

      <div class="card_ordem_servico">
        <div class="card_foto">
          <img src="<?= $imgAntes ?>" alt="<?= $altAntes ?>">
        </div>

      </div>

      <div class="card_ordem_servico">
        <div class="card_foto">
          <img src="<?= $imgDepois ?>" alt="<?= $altDepois ?>">
        </div>

      </div>
    </div>

    <h2 class="titulo">Serviços</h2>

    <?php require('templates/card_servicos.php') ?>

    <div class="card2_container <?= $bg ?>">

      <div class="card2_body">

        <div>
          <p>Valor Total</p>
          <p>R$ <?= number_format($ordemServico['valor_total_ordem'], 2, ',', '.') ?></p>
        </div>

        <div>
          <p>Data abertura:</p>
          <p><?= date('d/m/Y', strtotime($ordemServico['data_abertura_ordem'])) ?></p>
        </div>

        <?php if ($ordemServico['status_ordem'] == 'Fechada'): ?>
          <div>
            <p>Data fechamento:</p>
            <p><?= date('d/m/Y', strtotime($ordemServico['data_fechamento_ordem'])) ?></p>
          </div>
        <?php endif; ?>

        <div>
          <span>Status</span>

          <?php
          // Define classe para status
          $statusClass = '';
          switch ($ordemServico['status_ordem']) {
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
          ?>

          <span class="<?= $statusClass ?>"><?= htmlspecialchars($ordemServico['status_ordem'], ENT_QUOTES, 'UTF-8') ?></span>
        </div>

      </div>

    </div>


  </section>

  <?php require_once("templates/menuNav.php") ?>

</body>



</html>