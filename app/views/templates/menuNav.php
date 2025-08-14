<?php
$url = $_GET['url'] ?? 'home';
?>

<nav class="menu-mobile">
    <ul class="menu-ancoras app">
        <li class="<?= $url == 'home' ? 'ativar' : '' ?>">
            <a href="<?= BASE_URL_APP ?>index.php?url=home">
                <img src="<?= BASE_URL_APP ?>assets/img/casa.svg" alt="Início">
            </a>
        </li>
        <li class="<?= $url == 'veiculos' ? 'ativar' : '' ?>">
            <a href="<?= BASE_URL_APP ?>index.php?url=veiculos">
                <img src="<?= BASE_URL_APP ?>assets/img/carro.svg" alt="Meus veículos">
            </a>
        </li>
        <li class="<?= $url == 'listarAgendamentos' ? 'ativar' : '' ?>">
            <a href="<?= BASE_URL_APP ?>index.php?url=listarAgendamentos">
                <img src="<?= BASE_URL_APP ?>assets/img/calendario.svg" alt="Agendamentos">
            </a>
        </li>
        <li class="<?= $url == 'servicos' ? 'ativar' : '' ?>">
            <a href="<?= BASE_URL_APP ?>index.php?url=servicos">
                <img class="menuServ" src="<?= BASE_URL_APP ?>assets/img/menuserv.svg" alt="Serviços">
            </a>
        </li>
        <li class="<?= $url == 'configuracoes' ? 'ativar' : '' ?>">
            <a href="<?= BASE_URL_APP ?>index.php?url=configuracoes">
                <img src="<?= BASE_URL_APP ?>assets/img/config.svg" alt="Configurações">
            </a>
        </li>
    </ul>
</nav>