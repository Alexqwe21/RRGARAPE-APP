<?php

class PerfilController extends Controller
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

        //Buscar o cliente na API
        $url = BASE_API . "buscarCliente/" . $dadosToken['id'];

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
            echo "Erro ao buscar o cliente na API. \n
            Código HTTP: $statusCode";
            exit;
        }

        //Separa os dados em 'campos'
        $cliente = json_decode($response, true);

        // ENVIO DO FORMULÁRIO
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Verifica se a senha atual informada corresponde a senha cadastrada no DB
            if (!empty($_POST['senhaAtual']) && !password_verify($_POST['senhaAtual'], $cliente['senha_cliente'])) {
                $_SESSION['msg-erro'] = 'Senha atual inválida';
                header("Location: " . BASE_URL_APP . "index.php?url=perfil");
                exit;
            }

            $senha = $_POST['novaSenha'] ?? null;

            $dadosCliente = [
                'nome_cliente'       => trim($_POST['nome'] ?? null),
                'email_cliente'      => trim($_POST['email'] ?? null),
                'telefone_cliente'   => trim($_POST['telefone'] ?? null),
                'tipo_cliente'       => trim($_POST['tipo_cliente'] ?? null),
                'cpf_cnpj_cliente'   => trim($_POST['cpf_cnpj'] ?? null),
                'data_nasc_cliente'  => trim($_POST['dataNascimento'] ?? null),
                'endereco_cliente'   => trim(($_POST['logradouro'] ?? null) . ', ' . ($_POST['numero'] ?? '')),
                'bairro_cliente'     => trim($_POST['bairro'] ?? null),
                'cidade_cliente'     => trim($_POST['cidade'] ?? null),
                'sigla_uf'           => trim($_POST['uf'] ?? null)
            ];

            if ($senha) {
                $dadosCliente['senha_cliente'] = $senha;
            }

            // Junta os dados do formulário
            $dadosEnviar = $dadosCliente;
            $dadosEnviar['alt_cliente'] = 'Sem foto';
            // Se houver imagem, adiciona como CURLFile
            if (isset($_FILES['foto_cliente']) && $_FILES['foto_cliente']['error'] === UPLOAD_ERR_OK) {
                $dadosEnviar['foto_cliente'] = new CURLFile(
                    $_FILES['foto_cliente']['tmp_name'],
                    $_FILES['foto_cliente']['type'],
                    $_FILES['foto_cliente']['name']
                );
                $dadosEnviar['alt_cliente'] = $dadosCliente['nome_cliente'];
            }

            $url = BASE_API . "atualizarCliente/" . $dadosToken['id'];
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $dadosEnviar);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $_SESSION['token']
            ]);

            $resposta = curl_exec($ch);
            $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            $response = json_decode($resposta, true);

            if ($statusCode == 200 && isset($response['sucesso']) && $response['sucesso']) {
                $_SESSION['msg-sucesso'] = $response['mensagem'] ?? 'Dados atualizados com sucesso!';
            } else {
                $_SESSION['msg-erro'] = $response['erro'] ?? 'Erro ao atualizar os dados.';
            }

            header("Location: " . BASE_URL_APP . "index.php?url=perfil");
            exit;
        }

        //Fazer a busca da lista de estados
        $urlEstados = BASE_API . "listarEstados";
        $chEstado = curl_init($urlEstados);
        curl_setopt($chEstado, CURLOPT_RETURNTRANSFER, true);
        $responseEstado = curl_exec($chEstado);
        //Obtém o código HTTP da resposta (200, 400, 401)
        $statusCodeEstados = curl_getinfo($chEstado, CURLINFO_HTTP_CODE);
        curl_close($chEstado);
        $estados = ($statusCodeEstados == 200) ? json_decode($responseEstado, true) : [];




        $dados = array();
        $dados['titulo'] = 'RRGARAGE - Perfil';
        $dados['cliente'] = $cliente ?? 'Cliente';
        $dados['estados'] = $estados;

        $this->carregarViews('perfil', $dados);
    }
}
