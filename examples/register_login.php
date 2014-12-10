<?php
require_once('../lib/zmq.php');


  $message = array(
      'id' => 1,
      'method' => 'register',
      'params' => array('login' => 'aldor', 'password' => 'aldor', 'email' => 'aldor', 'name' => 'aldor', 'surname' => 'aldor')
  );

  $zmq = new ZMQMessage('tcp://178.238.41.170:5555');

  // Send message to the server
  $zmq->send($message);
  print_r($zmq->recv());
  $message = array(
      'id' => 1,
      'method' => 'login',
      'params' => array('login' => 'aldor', 'password' => 'aldor')
  );
  echo "\n----------------------\n";
  $zmq->send($message);
  print_r($zmq->recv());


