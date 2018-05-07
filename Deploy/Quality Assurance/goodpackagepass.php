<?php
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
session_start();
$GLOBALS['json'] = $SESSION['json'];
class Sender {
	private $connection;
	private $channel;
	private $callback_queue;
	private $response;
	private $corr_id;
	public function __construct() {

		$Server = '192.168.2.2';//Set to IP of Orchestration Server

		$this->connection = new AMQPStreamConnection(
			$Server, 5672, 'admin', 'pass');
		$this->channel = $this->connection->channel();
		list($this->callback_queue, ,) = $this->channel->queue_declare(
			"", false, false, true, false);
		$this->channel->basic_consume(
			$this->callback_queue, '', false, false, false, false,
			array($this, 'on_response'));
	}
	public function on_response($rep) {
		if($rep->get('correlation_id') == $this->corr_id) {
			$this->response = $rep->body;
		}
	}
	public function call($n) {
		$this->response = null;
		$this->corr_id = uniqid();
		
		$msg = new AMQPMessage(
			 $GLOBALS['json'],
			array('correlation_id' => $this->corr_id,
			      'reply_to' => $this->callback_queue)
			);
		$this->channel->basic_publish($msg, '', 'QA_Good');
//		echo "[x] Message sent:";
		while(!$this->response) {
			$this->channel->wait();
		}
		return $this->response;
	}
};
$sender_rpc = new Sender();
$response = $sender_rpc->call(30);
//echo "[X] Received the response: " . (string) $response . "\n";
echo (string) $response;
?>
