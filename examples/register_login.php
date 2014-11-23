<?php
require_once '../lib/zmq.php';


  $message = array(
      'id' => 1,
      'method' => 'register',
      'params' => array('login' => 'aldor', 'password' => 'aldor', 'email' => 'aldor', 'name' => 'aldor', 'surname' => 'aldor')
  );

  $zmq = new ZMQMessage();

  // Send message to the server
  $zmq->connect('tcp://127.0.0.1:5555');
  $zmq->send($message);
  echo $zmq->recv();
  $message = array(
      'id' => 1,
      'method' => 'login',
      'params' => array('login' => 'aldor', 'password' => 'aldor')
  );
  echo "\n----------------------\n";
  $zmq->send($message);
  echo $zmq->recv();


