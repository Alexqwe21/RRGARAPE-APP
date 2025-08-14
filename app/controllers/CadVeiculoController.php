<?php

class CadVeiculoController extends Controller
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
        $dados['titulo'] = 'RRGARAGE - Cadastrar Veículo';

        $this->carregarViews('cadVeiculo', $dados);
    }


    public function cadastrarVeiculoApp()
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

        $categoria = $_POST['categoria'] ?? null;
        $marca = $_POST['marca'] ?? null;
        $modelo = $_POST['modelo'] ?? null;
        $ano = $_POST['ano'] ?? null;
        $placa = $_POST['placa'] ?? null;
        $chassi = $_POST['chassi'] ?? null;
        $cor = $_POST['cor'] ?? null;

        if (empty($categoria) || empty($marca) || empty($modelo) || empty($ano) || empty($placa) || empty($chassi) || empty($cor)) {
            $_SESSION['msg-erro'] = 'Preencha todos os campos';
            header("Location: " . BASE_URL_APP . "index.php?url=cadVeiculo");
            exit;
        }

        $postData = [
            'categoria_veiculo' => $categoria,
            'marca_veiculo' => $marca,
            'modelo_veiculo' => $modelo,
            'ano_veiculo' => $ano,
            'placa_veiculo' => $placa,
            'chassi_veiculo' => $chassi,
            'cor_veiculo' => $cor,
            'status_veiculo' => 'Ativo'
        ];

        $url = BASE_API . "cadastrarVeiculo/" . $dadosToken['id'];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $_SESSION['token']
        ]);

        $resposta = curl_exec($ch);
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($statusCode == 200) {
            $response = json_decode($resposta, true);

            if ($response['sucesso']) {
                $_SESSION['msg-sucesso'] = $response['mensagem'] ?? 'Veículo cadastrado com sucesso!';
                header("Location: " . BASE_URL_APP . "index.php?url=cadVeiculo");
                exit;
            } else {
                $_SESSION['msg-erro'] = $response['erro'] ?? 'Erro ao cadastrar o veículo, contate o administrador do sistema.';
                header("Location: " . BASE_URL_APP . "index.php?url=cadVeiculo");
                exit;
            }
        } else {
            header("Location: " . BASE_URL_APP . "index.php?url=login");
            exit;
        }
    }
}
