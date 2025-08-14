<?php

class CadClienteController extends Controller
{
    public function index()
    {
        $dados = array();
        $dados['titulo'] = 'RRGARAGE - Cadastrar Cliente';

        $this->carregarViews('cadCliente', $dados);
    }

    public function cadastrarCliente()
    {
        $nome_cliente = $_POST['nome_cliente'] ?? null;
        $telefone_cliente = $_POST['telefone_cliente'] ?? null;
        $email_cliente = $_POST['email_cliente'] ?? null;
        $senha_cliente = $_POST['senha_cliente'] ?? null;
        $confirmarSenha = $_POST['confirmarSenha'] ?? '';

        if (strlen($senha_cliente) < 8) {
            $_SESSION['msg-erro'] = 'A senha deve conter no mínimo 8 caracteres.';
            header("Location: " . BASE_URL_APP . "index.php?url=cadCliente");
            exit;
        }

        if ($senha_cliente !== $confirmarSenha) {
            $_SESSION['msg-erro'] = 'As senhas não coincidem.';
            header("Location: " . BASE_URL_APP . "index.php?url=cadCliente");
            exit;
        }


        if (empty($nome_cliente) || empty($telefone_cliente) || empty($email_cliente) || empty($senha_cliente)) {
            echo 'Preencha todos os campos';
            return;
        }

        $postData = [
            'nome_cliente' => $nome_cliente,
            'telefone_cliente' => $telefone_cliente,
            'email_cliente' => $email_cliente,
            'senha_cliente' => $senha_cliente
        ];

        $url = BASE_API . "cadastrarCliente";



        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));

        $resposta = curl_exec($ch);
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($statusCode == 200) {
            $response = json_decode($resposta, true);

            if ($response['sucesso']) {
                $_SESSION['msg-sucesso'] = $response['mensagem'] ?? 'Cliente cadastrado com sucesso!';
                header("Location: " . BASE_URL_APP . "index.php?url=cadCliente");
                exit;
            } else {
                $_SESSION['msg-erro'] = $response['erro'] ?? 'Erro inesperado: resposta da API não reconhecida.';
                header("Location: " . BASE_URL_APP . "index.php?url=cadCliente");
                exit;
            }
        } else {
            $_SESSION['msg-erro'] = $response['erro'] ??  'Erro ao cadastrar, contate o administrador do sistema ou tente novamente mais tarde!';
            header("Location: " . BASE_URL_APP . "index.php?url=cadCliente");
            exit;
        }
    }
}
