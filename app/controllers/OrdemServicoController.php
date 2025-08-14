<?php

class OrdemServicoController extends Controller
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
        $dados['titulo'] = 'RRGARAGE - Ordem de Serviço';

        $this->carregarViews('ordemServico', $dados);
    }

    public function detalhe($idOrdem)
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

        //Buscar as serviço executado na API
        $url = BASE_API . "ListarDetalhesOrdensServico/" . $dadosToken['id'] . "/" . $idOrdem;

        //Reconhecimento da chave (Inicializa uma sessão cURL)
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $_SESSION['token']
        ]);

        //Recebe os dados dessa solicitação
        $response = curl_exec($ch);
        //Obtém o código HTTP da resposta (200, 400, 401)
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        //Encerra a sessão da chave
        curl_close($ch);

        if ($statusCode != 200) {
            echo "Erro ao buscar os ordem de serviço na API. \n
            Código HTTP: $statusCode";
            exit;
        }

        //Separa os dados em 'campos'
        $detalhesOrdemServico = json_decode($response, true);

        $ordemServico = [];
        $servExecutados = [];

        if (is_array($detalhesOrdemServico) && isset($detalhesOrdemServico['ordem_servico']) && is_array($detalhesOrdemServico['ordem_servico'])) {
            $ordemServico = $detalhesOrdemServico['ordem_servico'];
            $servExecutados = $detalhesOrdemServico['servicos_executados'];
        }

        $dados = array();
        $dados['titulo'] = 'RRGARAGE - Ordem de Serviço';
        $dados['servExecutados'] = $servExecutados;
        $dados['ordemServico'] = $ordemServico[0]; // pegar só o primeiro item




        $this->carregarViews('ordemServico', $dados);
    }
}
