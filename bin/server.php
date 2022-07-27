<?php
require __DIR__ . '/vendor/autoload.php';
require 'src/MyApp/Chat.php';
use MyChatApp\Chat;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

$server = IoServer::factory(
            new HttpServer(
                new WsServer(
                    new Chat()
                )
            ),
          8087
         );$server->run();