#!/usr/bin/php
<?php
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
$connection = new AMQPStreamConnection('localhost', 5672, 'admin', 'pass');
$channel = $connection->channel();
$channel->queue_declare('QA_Good', false, false, false, false);
echo " [x] Awaiting RPC requests\n";
$callback = function($req) {
	include('goodpackagef.php');
};
$channel->basic_qos(null, 1, null);
$channel->basic_consume('QA_Good', '', false, false, false, false, $callback);
while(count($channel->callbacks)) {
    $channel->wait();
}
$channel->close();
$connection->close();
?>
