<?php
require_once __DIR__ . '/../_header.php';

use Ratchet\Server\IoServer;
use api\v1\Chat;

const PORT = 8181;

$server = IoServer::factory(
    new Chat(),
    8181
);

$server->run();