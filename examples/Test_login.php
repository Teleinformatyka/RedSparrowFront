
<?php
require_once('../lib/zmqmessage.php');

 $zmq = new ZMQMessage('tcp://aldorhost.pl:5555');
 echo "\n---------REGISTR-------------\n";

 $message = array(
'id' => 1,
'method' => 'login',
'params' => array('login' => 'buli', 'password' => 'buli')
);
 $zmq->send($message);
print_r($zmq->recv());
 $message = array(
'id' => 214,
'method' => 'register',
'params' => array('login' => 'buli', 'password' => 'buli', 'email' => 'budddli@pp.pl', 'name' => 'buli', 'surname' => 'buli')
);
 $zmq->send($message);
print_r($zmq->recv());

 $message = array(
'id' => 214,
'method' => 'login',
'params' => array('login' => 'buli', 'password' => 'buli')
);
 $zmq->send($message);
print_r($zmq->recv());

?>
