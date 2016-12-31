<?php
require_once __DIR__ . '/../_header.php';

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use api\v2\Chat;

const PORT = 8282;

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new Chat()
        )
    ),
    PORT
);

$server->run();