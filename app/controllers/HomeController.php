<?php

class HomeController extends Controller
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

        $dados = [];

        // Busca o cliente
        $result = $this->chamarApi("buscarCliente/" . $dadosToken['id']);
        $dados['cliente'] = ($result['statusCode'] === 200 && is_array($result['response']))
            ? $result['response']
            : [];

        // Busca os banners
        $result = $this->chamarApi("listarbanner");
        if ($result['statusCode'] != 200) {
            $dados['mensagemBanner'] = $result['response'];
        } else {
            $dados['banner'] = $result['response'];
        }

        // Busca os dados da Newsletter com base no e-mail do cliente
        $emailCliente = $dados['cliente']['email_cliente'] ?? null;


        if ($emailCliente) {
            $resultado = $this->chamarApi("buscarNewsletter", [
                'email_newsletter' => $emailCliente
            ], 'POST');

            if ($resultado['statusCode'] === 200 && !empty($resultado['response']['sucesso'])) {
                $dados['newsletter'] = $resultado['response'];
            } else {
                $dados['newsletter'] = ['sucesso' => []]; // Garante que não quebre no HTML
                $dados['mensagemNewsletter'] = $resultado['response']['erro'] ?? 'Não foi possível verificar a newsletter.';
            }
        }

        // Lista ordens de serviço
        $result = $this->chamarApi("ListarOrdensServicoAbertas/" . $dadosToken['id']);
        if ($result['statusCode'] != 200) {
            $dados['mensagemOrdem'] = $result['response']['mensagem'];
        } else {
            $dados['ordens'] = $result['response'];
        }

        // Busca próximo agendamento
        $result = $this->chamarApi("proxAgendamento/" . $dadosToken['id']);
        if ($result['statusCode'] != 200) {
            $dados['mensagemAgenda'] = $result['response']['mensagem'];
            $dados['agendamento'] = null;
        } else {
            $dados['agendamento'] = $result['response'];
        }

        $dados['titulo'] = 'RRGARAGE - Home';

        $this->carregarViews('home', $dados);
    }

    public function cadastrarDepoimento()
    {
        if (!isset($_SESSION['token'])) {
            header("Location: " . BASE_URL_APP . "index.php?url=login");
            exit;
        }

        $descricao = $_POST['descricao_depoimento'] ?? null;
        $nota = $_POST['nota_depoimento'] ?? null;

        // Analisar preenchimento da descrição e da nota
        if (empty($descricao) || empty($nota)) {
            $_SESSION['msg-erro'] = 'Ops! Dê uma nota e escreva algo antes de enviar o depoimento 😊.';
            header("Location: " . BASE_URL_APP . "index.php?url=home");
            exit;
        }

        $postData = [
            'descricao_depoimento' => $descricao,
            'nota_depoimento' => $nota

        ];

        $url = BASE_API . "cadastrarDepoimento";

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $_SESSION['token']

        ]);

        $resposta = curl_exec($ch);
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($statusCode == 200) {
            $response = json_decode($resposta, true);

            if (isset($response['mensagem']) && $response['mensagem'] === 'Depoimento cadastrado com sucesso!') {
                $_SESSION['msg-sucesso'] = $response['mensagem'];
            } else {
                $_SESSION['msg-erro'] = $response['erro'] ?? 'Erro ao enviar depoimento.';
            }

            header("Location: " . BASE_URL_APP . "index.php?url=home");
            exit;
        } else {
            header("Location: " . BASE_URL_APP . "index.php?url=login");
            exit;
        }
    }

    public function cadastrarnewsletter()
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

        $dadosnewsletter = [
            'email'       => $dadosToken['email'] ?? null
        ];

        $url = BASE_API . "enviarEmailNewsletter";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dadosnewsletter);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $_SESSION['token']
        ]);

        $resposta = curl_exec($ch);
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $response = json_decode($resposta, true);

        if ($statusCode == 200 && isset($response['sucesso']) && $response['sucesso']) {
            $_SESSION['msg-sucesso'] = $response['mensagem'] ?? '🎉 Sucesso! Você agora faz parte da nossa newsletter!';
        } else {
            $_SESSION['msg-erro'] = $response['mensagem'] ?? 'Erro ao inscrever na newsletter';
        }

        header("Location: " . BASE_URL_APP . "index.php?url=home");
        exit;
    }

    private function chamarApi($endpoint, $data = [], $method = 'GET')
    {
        $url = BASE_API . $endpoint;

        $ch = curl_init($url);

        $headers = [
            'Authorization: Bearer ' . $_SESSION['token'],
            'Content-Type: application/json'
        ];

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }

        $response = curl_exec($ch);
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $decoded = json_decode($response, true);

        return [
            'statusCode' => $statusCode,
            'response' => $decoded,
            'raw' => $response
        ];
    }

    public function cancelarAgendamento($idAgendamento)
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

        $dadosCancelamento = [
            'id_agendamento' => $idAgendamento,
            'status_agendamento' => 'Cancelado',
            'motivo_cancelamento' => 'Cancelado pelo cliente.'
        ];

        $url = BASE_API . "atualizarAgendamento/" . $dadosToken['id'];
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($dadosCancelamento));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $_SESSION['token']
        ]);

        $resposta = curl_exec($ch);
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $response = json_decode($resposta, true);

        if ($statusCode == 200 && isset($response['mensagem'])) {
            $_SESSION['msg-sucesso'] = $response['mensagem'];
        } else {
            $_SESSION['msg-erro'] = $response['erro'] ?? 'Erro ao cancelar o agendamento.';
        }

        header("Location: " . BASE_URL_APP . "index.php?url=home");
        exit;
    }
}
