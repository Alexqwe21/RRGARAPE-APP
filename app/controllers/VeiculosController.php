<?php

class VeiculosController extends Controller
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
        $url = BASE_API . "ListarVeiculo/" . $dadosToken['id'];

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
            echo "Erro ao buscar os agendamentos de serviço na API. \n
              Código HTTP: $statusCode";
            exit;
        }

        //Separa os dados em 'campos'
        $listarVeiculo = json_decode($response, true);

        $veiculos = [];

        if (is_array($listarVeiculo) && isset($listarVeiculo[0]) && is_array($listarVeiculo[0])) {
            $veiculos = $listarVeiculo;
        }

        $dados = array();
        $dados['titulo'] = 'RRGARAGE - Minhas Ordens de Serviço';
        $dados['id_cliente'] = $dadosToken['id'];
        $dados['veiculos'] = $veiculos;

        $this->carregarViews('veiculos', $dados);
    }


    public function detalhe($idVeiculo)
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

        // URL da API para buscar um veículo por ID
        $url = BASE_API . "listarVeiculoById/" . $dadosToken['id'] . "/" . $idVeiculo;


        // Inicializa cURL
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $_SESSION['token']
        ]);

        // Executa a requisição
        $response = curl_exec($ch);
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($statusCode != 200) {
            echo "Erro ao buscar dados do veículo na API.<br>Código HTTP: $statusCode";
            exit;
        }

        // Decodifica os dados do veículo
        $veiculo = json_decode($response, true);

        if (!is_array($veiculo) || !isset($veiculo['id_veiculo'])) {
            echo "Veículo não encontrado ou dados inválidos.";
            exit;
        }

        // Prepara os dados para a view
        $dados = [];
        $dados['titulo'] = 'RRGARAGE - Detalhe do Veículo';
        $dados['veiculo'] = $veiculo;

        $this->carregarViews('veiculo_detalhe', $dados);
    }

    public function atualizarVeiculo($idVeiculo)
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

        $dadosVeiculo = [
            'id_veiculo' => $idVeiculo,
            'categoria_veiculo' => $_POST['categoria'] ?? null,
            'marca_veiculo'     => $_POST['marca'] ?? null,
            'modelo_veiculo'    => $_POST['modelo'] ?? null,
            'ano_veiculo'       => $_POST['ano'] ?? null,
            'placa_veiculo'     => $_POST['placa'] ?? null,
            'chassi_veiculo'    => $_POST['chassi'] ?? null,
            'cor_veiculo'       => $_POST['cor'] ?? null
        ];

        $url = BASE_API . "atualizarVeiculo/" . $dadosToken['id'] . "/" . $idVeiculo;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($dadosVeiculo));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $_SESSION['token']
        ]);

        $resposta = curl_exec($ch);
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $response = json_decode($resposta, true);

        if ($statusCode == 200 && isset($response['sucesso']) && $response['sucesso']) {
            $_SESSION['msg-sucesso'] = $response['mensagem'] ?? 'Veículo atualizado com sucesso!';
        } else {
            $_SESSION['msg-erro'] = $response['erro'] ?? 'Erro ao atualizar o veículo. Tente novamente mais tarde.';
        }

        header("Location: " . BASE_URL_APP . "index.php?url=veiculos/detalhe/" . $idVeiculo);
        exit;
    }
}
