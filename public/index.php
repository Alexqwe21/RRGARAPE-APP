<?php
// Carregue as configurações iniciais da aplicação
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('../config/config.php');

$caminho = new Rotas();
$caminho->executar();
