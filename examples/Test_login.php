
<?php
require_once('../lib/zmqmessage.php');

 $zmq = new ZMQMessage('tcp://aldorhost.pl:5555');
 echo "\n---------Login-------------\n";

 $message = array(
'id' => 300,
'method' => 'login',
'params' => array('login' => 'buli', 'password' => 'buli')
);
 $zmq->send($message);
print_r($zmq->recv());
 echo "<br/>---------LOGIN end-------------<br/>";
  echo "<br/>---------REGISTER -------------<br/>";
 $message = array(
'id' => 300,
'method' => 'register',
'params' => array('login' => 'buli', 'password' => 'buli', 'email' => 'budddli@pp.pl', 'name' => 'buli', 'surname' => 'buli')
);
 $zmq->send($message);
print_r($zmq->recv());
 echo "<br/>---------REGISTER end-------------<br/>";
   echo "<br/>---------REGISTER -------------<br/>";
 $message = array(
'id' => 300,
'method' => 'register',
'params' => array('login' => 'buli1', 'password' => 'buli', 'email' => 'budddli@pp.pl', 'name' => 'buli', 'surname' => 'buli')
);
 $zmq->send($message);
print_r($zmq->recv());
 echo "<br/>---------REGISTER end-------------<br/>";
 echo "<br/>---------LOGIN-------------<br/>";
 
 $message = array(
'id' => 300,
'method' => 'login',
'params' => array('login' => 'buli', 'password' => 'buli')
);
 $zmq->send($message);
print_r($zmq->recv());
 echo "<br/>---------LOGIN end-------------<br/>";
 
?>
