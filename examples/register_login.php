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
  $message = array(
      'id' => 1,
      'method' => 'login',
      'params' => array('login' => 'aldor', 'password' => 'aldor')
  );
  echo "\n---------LOGIN-------------\n";
  $zmq->send($message);
  print_r($zmq->recv());
 $message = array(
     'jsonrpc' => '2.0',
     'method' => 'usermethods-edit_user',
     'params' => array('columnName' => 'password', 'value' => md5('trombka2'), 'userId' => 6),
     'id' => 6621
   );
  echo "\n---------usermethods-edit_user-------------\n";
  $zmq->send($message);
  print_r($zmq->recv());




  $user_del = array(
      'id' => 1,
      'method' => 'register',
      'params' => array('login' => 'aldor', 'password' => 'aldor', 'email' => 'aldor', 'name' => 'aldor', 'surname' => 'aldor')
  );


  echo "\n---------register-------------\n";
  $zmq->send($user_del);
  print_r($zmq->recv());
