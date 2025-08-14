<?php

class ContatoController extends Controller
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
        $dados['titulo'] = 'RRGARAGE - Contato';

        $this->carregarViews('contato', $dados);
    }

    public function enviarEmail()
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

        $id = $dadosToken['id'] ?? null; // id do usuário logado
        $email = $dadosToken['email'] ?? null; // Email do usuário logado
        $assunto = $_POST['assunto'] ?? null;
        $mensagem = $_POST['mensagem'] ?? null;

        // Analisar preenchimento da descrição e da nota
        if (empty($assunto) || empty($mensagem)) {
            $_SESSION['msg-erro'] = 'Preencha todos os campos';
            header("Location: " . BASE_URL_APP . "index.php?url=contato");
            exit;
        }

        $postData = [
            'id' => $id,
            'email' => $email,
            'assunto' => $assunto,
            'mensagem' => $mensagem

        ];

        $url = BASE_API . "enviarEmail";
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
        $response = json_decode($resposta, true);

        if ($statusCode == 200 && isset($response['sucesso']) && $response['sucesso']) {
            $_SESSION['msg-sucesso'] = $response['mensagem'];
            header("Location: " . BASE_URL_APP . "index.php?url=contato");
            exit;
        } else {
            $_SESSION['msg-erro'] = $response['erro'];
            header("Location: " . BASE_URL_APP . "index.php?url=contato");
            exit;
        }
    }
}
