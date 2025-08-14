<?php

class MinhasOrdensController extends Controller
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

        if (!$dadosToken) {
            session_destroy();
            unset($_SESSION['token']);
            header("Location: " . BASE_URL_APP . "index.php?url=login");
            exit;
        }

        //Buscar as serviço executado na API
        $url = BASE_API . "ListarOrdensServico/" . $dadosToken['id'];

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

        $dados = array();
        //Separa os dados em 'campos'
        $listarordens = json_decode($response, true);
        $dados['ordens'] = $listarordens;

        if ($statusCode != 200) {
            $dados['mensagemOrdem'] = $listarordens['mensagem'] ?? 'Nenhuma ordem de serviço encontrada.';
            $dados['ordens'] = [];
        }

        $dados['titulo'] = 'RRGARAGE - Minhas Ordens de Serviço';
        $dados['id_cliente'] = $dadosToken['id'];

        $this->carregarViews('minhasOrdens', $dados);
    }
}
