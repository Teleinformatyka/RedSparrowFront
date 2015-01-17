
<?php
require_once('../lib/zmqmessage.php');

$message = array(
'id' => 214,
'method' => 'register',
'params' => array('login' => 'aldor', 'password' => 'aldor', 'email' => 'aldor', 'name' => 'aldor', 'surname' => 'aldor')
);
$zmq = new ZMQMessage('tcp://aldorhost.pl:5555');
// Send message to the server
$zmq->send($message);
print_r($zmq->recv());

?>
