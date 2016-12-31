<?php
require_once __DIR__ . '/../_header.php';

use Ratchet\App;
use api\v3\Chat;

const PORT = 8383;
$controller = new Chat();

$server = new App();
$server->route('/hello', $controller);
$server->run();