<?php

namespace App\WebSocket;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use PDO;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class Chat implements MessageComponentInterface
{
    protected $connections;
    protected $pdo;
    protected $logger;

    public function __construct()
    {
        $this->connections = new \SplObjectStorage;

        // Set up the logger
        $this->logger = new Logger('chat');
        $this->logger->pushHandler(new StreamHandler(__DIR__ . '/../../storage/logs/chat.log', Logger::ERROR));

        // Set up the PDO connection
        $this->setupDatabaseConnection();
    }

    protected function setupDatabaseConnection()
    {
        $databaseConfig = config('database.connections.mysql');

        $dsn = 'mysql:host=' . $databaseConfig['host'] . ';dbname=' . $databaseConfig['database'];
        $username = $databaseConfig['username'];
        $password = $databaseConfig['password'];

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];

        $this->pdo = new PDO($dsn, $username, $password, $options);
    }

    protected function reconnectDatabase()
    {
        $this->setupDatabaseConnection();
    }

    public function onOpen(ConnectionInterface $conn)
    {
        $this->connections->attach($conn);
    }

    public function onClose(ConnectionInterface $conn)
    {
        $this->connections->detach($conn);
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        $this->logger->error('Connection error: ' . $e->getMessage());
        $conn->close();
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        // Parse the JSON message
        $data = json_decode($msg, true);

        // Handle heartbeat
        if (isset($data['type']) && $data['type'] === 'heartbeat') {
            return;
        }

        $role_id = $data['role_id'];
        $server_id = $data['server_id'];
        $role_name = $data['role_name'];
        $chat_channel = $data['chat_channel'];
        $content = $data['message'];
        $time = date("Y-m-d H:i:s", time());

        // Save the message to the database
        try {
            $stmt = $this->pdo->prepare("INSERT INTO dp_chats (server_id, role_id, role_name, chat_channel, content, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$server_id, $role_id, $role_name, $chat_channel, $content, $time, $time]);
        } catch (\PDOException $e) {
            $this->logger->error('Database error: ' . $e->getMessage());

            // Reconnect and retry
            $this->reconnectDatabase();

            try {
                $stmt = $this->pdo->prepare("INSERT INTO dp_chats (server_id, role_id, role_name, chat_channel, content, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([$server_id, $role_id, $role_name, $chat_channel, $content, $time, $time]);
            } catch (\PDOException $e) {
                $this->logger->error('Database reconnection error: ' . $e->getMessage());
            }
        }

        // Broadcast the message to all connected clients
        foreach ($this->connections as $conn) {
            $conn->send($role_name . ": " . $content);
        }
    }
}
