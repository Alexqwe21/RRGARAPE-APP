<?php

class ConfiguracoesController extends Controller
{
    public function index()
    {
        if (!isset($_SESSION['token'])) {
            header("Location: " . BASE_URL_APP . "index.php?url=login");
            exit;
        }

        $dadosToken = TokenHelper::validar($_SESSION['token']);

        if (!$dadosToken) {
            session_destroy();
            unset($_SESSION['token']);
            header("Location: " . BASE_URL_APP . "index.php?url=login");
            exit;
        }
        
        $dados = array();
        $dados['titulo'] = 'RRGARAGE - Configurações';

        $this->carregarViews('configuracoes', $dados);
    }
}
