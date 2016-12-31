<?php
namespace api\v1;

require_once __DIR__ . '/../_header.php';

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Chat implements MessageComponentInterface {

    // ACTIONS
    const STOP_SERVER = 'stop_server';


    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) {
        // Store the new connection to send messages to later
        $this->clients->attach($conn);

        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {

        $request = $this->parseRequest($msg);
        echo '<pre>';
        print_r($request);
        echo '</pre>';

        switch ($request->action) {
            case self::STOP_SERVER:
                exit('Server stopped.');
                break;
            default:

        }

//        $numRecv = count($this->clients) - 1;
//        echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n"
//            , $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');
//
//        foreach ($this->clients as $client) {
//            if ($from !== $client) {
//                // The sender is not the receiver, send to each client connected
//                $client->send($msg);
//            }
//        }
    }

    public function parseRequest($msg) {
        $pattern = '%(\{.*\})%';
//        $pattern = '%(\{.*(?:\}.*)*\})%';
        preg_match($pattern, $msg, $request);
        return json_decode($request[0]);
    }

    public function onClose(ConnectionInterface $conn) {
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }
}