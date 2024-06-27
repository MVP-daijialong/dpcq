<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use App\WebSocket\Chat;

class WebSocketServer extends Command
{
    protected $signature = 'websocket:serve';

    protected $description = 'Start the WebSocket server';

    public function handle()
    {
        $server = IoServer::factory(
            new HttpServer(
                new WsServer(
                    new Chat()
                )
            ),
            6001
        );

        $server->run();
    }
}
