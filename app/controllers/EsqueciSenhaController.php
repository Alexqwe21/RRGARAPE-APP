<?php

class EsqueciSenhaController extends Controller
{
    public function index()
    {
        $dados = array();
        $dados['titulo'] = 'RRGARAGE - Esqueci Senha';

        $this->carregarViews('esqueciSenha', $dados);
    }

    public function recuperarSenha()
    {
        $email = $_POST['email_cliente'] ?? null;

        //Fazer a requisição da API de login
        $url = BASE_API . "recuperarSenha";

        $postFields = http_build_query([
            'email_cliente' => $email
        ]);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        $response = curl_exec($ch);
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $data = json_decode($response, true);

        if ($statusCode == 200) {
            $_SESSION['msg-sucesso'] = $data['mensagem'] ?? 'Um link de redefinição foi enviado para seu e-mail';
            header("Location: " . BASE_URL_APP . "index.php?url=esqueciSenha");
            exit;
        } else {
            $_SESSION['msg-erro'] = $data['erro'];
            header("Location: " . BASE_URL_APP . "index.php?url=esqueciSenha");
            exit;
        }
    }
}
