<?php
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
$messagebody = json_decode($req->body); //Change the value after $req to your variable set in the pass.php file
echo " [x] Received " . $req->body . "\n";
	if ($messagebody->boolean == True) {
	$returnValue = "{\"True\"}";
	shell_exec("php Update.php");//Execute script to get new version
	}

	else {
	echo "no update";
	}
	echo "Return value  is " . $returnValue;


    $msg = new AMQPMessage(
        $returnValue,
        array('correlation_id' => $req->get('correlation_id'))
        );
    $req->delivery_info['channel']->basic_publish(
        $msg, '', $req->get('reply_to'));
    $req->delivery_info['channel']->basic_ack(
        $req->delivery_info['delivery_tag']);
?>
