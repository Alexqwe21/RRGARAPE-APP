<?php

class ListarAgendamentosController extends Controller
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

        // Buscar os agendamentos de serviço na API
        $url = BASE_API . "listarAgendamentos/" . $dadosToken['id'];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $_SESSION['token']
        ]);

        $response = curl_exec($ch);
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $respostaApi = json_decode($response, true);
        $agendamentos = [];

        if ($statusCode === 200 && is_array($respostaApi)) {
            // Se é uma lista (array com índices numéricos), consideramos como agendamentos
            if (isset($respostaApi[0]) && is_array($respostaApi[0])) {
                $agendamentos = $respostaApi;
            }
        }

        $dados = [
            'titulo' => 'RRGARAGE - Lista de Agendamentos',
            'id_cliente' => $dadosToken['id'],
            'agendamentos' => $agendamentos,
            'mensagem' => $respostaApi['mensagem'] ?? null
        ];

        $this->carregarViews('listarAgendamentos', $dados);
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
            $_SESSION['msg_sucesso'] = $response['mensagem'];
        } else {
            $_SESSION['msg_erro'] = $response['erro'] ?? 'Erro ao cancelar o agendamento.';
        }

        header("Location: " . BASE_URL_APP . "index.php?url=listarAgendamentos");
        exit;
    }
}
