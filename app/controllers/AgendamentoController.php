<?php

class AgendamentoController extends Controller
{
    public function index()
    {
        $dados = array();
        $dados['titulo'] = 'RRGARAGE - Cadatrar agendamento';

        $this->carregarViews('agendamento', $dados);
    }

    public function curl($url)
    {
        //Reconhecimento da chave (Inicializa uma sessão cURL)
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //Recebe os dados dessa solicitação
        $response = curl_exec($ch);
        //Obtém o código HTTP da resposta (200, 400, 401)
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        //Encerra a sessão da chave
        curl_close($ch);
        if ($statusCode != 200) {
            echo "Erro ao buscar os dados na API. \n
            Código HTTP: $statusCode";
            exit;
        }

        return $response;
    }
}
