<?php
// Verifica se a variável existe e se a página atual é home
if (isset($url) && $url === 'home') {
  $bg = 'bg-black';
}
?>

<div class="card2_container <?= $bg ?? '' ?>" data-status="<?= $agendamento['status_agendamento'] ?>">
  <div>

    <div class="card2_header">
      <?php if ($agendamento['status_agendamento'] !== 'Cancelado'): ?>
        <button type="button" onclick="abrirModal(<?= $agendamento['id_agendamento'] ?>)">×</button>
      <?php endif; ?>
    </div>

    <div class="card2_body">

      <div>
        <p>Vistoria</p>
        <p class="<?= $statusClass ?>">
          <?= htmlspecialchars($agendamento['status_agendamento'], ENT_QUOTES, 'UTF-8') ?>
        </p>
      </div>


      <?php
      $dataHora = new DateTime($agendamento['data_agendamento']);
      $data = $dataHora->format('d/m/Y');
      $hora = $dataHora->format('H:i');
      ?>
      <div>
        <span><?= htmlspecialchars($data, ENT_QUOTES, 'UTF-8') ?></span>
        <span><?= htmlspecialchars($hora, ENT_QUOTES, 'UTF-8') ?></span>
      </div>

    </div>

  </div>

  <div class="motivo_cancelado">
    <?php if ($agendamento['status_agendamento'] === 'Cancelado'): ?>
      <?php $motivo = isset($agendamento['motivo_cancelamento']) ? $agendamento['motivo_cancelamento'] : ''; ?>
      <button onclick="abrirModalMotivo('<?= htmlspecialchars($motivo, ENT_QUOTES, 'UTF-8') ?>')"
        class="btn_app w-90">
        Ver motivo
      </button>
    <?php endif; ?>
  </div>
</div>
