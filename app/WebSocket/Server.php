<?php

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use Ratchet\Server\IoServer;
use React\EventLoop\LoopInterface;
use React\EventLoop\Factory;
use React\Socket\Server as ReactServer;

require_once __DIR__ . '/../../vendor/autoload.php';

class WebSocketServer implements MessageComponentInterface
{
    protected $clients;
    protected $loop;

    public function __construct(LoopInterface $loop)
    {
        $this->clients = new \SplObjectStorage;
        $this->loop = $loop;

        // Configura um timer para enviar atualizações a cada 1 segundo
        $this->loop->addPeriodicTimer(1, function () {
            $data = $this->fetchCpuData();

            if ($data) {
                $message = json_encode($data);
                foreach ($this->clients as $client) {
                    $client->send($message);
                }
            }
        });
    }

    public function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn);
        echo "New connection: ({$conn->resourceId})\n";
    
        // Envia o primeiro dado assim que o cliente conecta
        $data = $this->fetchCpuData();
        $conn->send(json_encode($data));
    }
    
    protected function fetchCpuData()
    {
        $apiUrl = 'http://109.123.248.92:5001/realtime-status'; // Altere conforme necessário
        $authorizationToken = '4b9f2a87-704e-4685-b0bf-668b1c5eb8b1'; // Substitua pelo seu token

        // Inicializa o cURL
        $ch = curl_init();

        // Configurações do cURL
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Retorna o resultado como string
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: $authorizationToken"
        ]);

        // Executa a chamada e captura a resposta
        $response = curl_exec($ch);

        // Verifica por erros na execução
        if (curl_errno($ch)) {
            $error = curl_error($ch);
            curl_close($ch);
            echo "Erro ao buscar os dados da CPU: $error\n";
            return null;
        }

        // Fecha a sessão cURL
        curl_close($ch);

        // Debug opcional
        echo "CPU data fetched via cURL: $response\n";

        // Retorna os dados como array associativo
        return json_decode($response, true);
    }
    
    public function onMessage(ConnectionInterface $from, $msg)
    {
        // Broadcast message to all clients
        foreach ($this->clients as $client) {
            if ($from !== $client) {
                $client->send($msg);
            }
        }
    }

    public function onClose(ConnectionInterface $conn)
    {
        $this->clients->detach($conn);
        echo "Connection closed: ({$conn->resourceId})\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "Error: {$e->getMessage()}\n";
        $conn->close();
    }
}


// Cria o loop de eventos do React
$loop = Factory::create();

// Configura o servidor de socket do React
$socket = new ReactServer('0.0.0.0:5001', $loop);

// Configura o servidor WebSocket com o loop
// Configura o servidor WebSocket
$server = new IoServer(
    new HttpServer(
        new WsServer(
            new WebSocketServer($loop)
        )
    ),
    $socket,
    $loop
);

// Executa o loop de eventos
$loop->run();