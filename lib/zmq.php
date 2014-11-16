<?php

class ZMQMessage {
  private $m_socket;
  
  /**
  *	Construct ZMQ message class
  *	@return NULL
  *	@param $buffer string
  **/
  public function __construct(){
    $this->m_socket = false;
  }
  
  /**
  *	Connect to given server
  *	@return NULL
  *	@param $server string
  **/
  public function connect($server){
    $this->m_socket = new ZMQSocket(new ZMQContext(), ZMQ::SOCKET_REQ);
    
    if($this->m_socket){
      $this->m_socket->setSockOpt(ZMQ::SOCKOPT_SNDTIMEO, 5000);
      $this->m_socket->setSockOpt(ZMQ::SOCKOPT_RCVTIMEO, 5000);
      $this->m_socket->connect($server);
    }
  }
  
  /**
  *	Send message from string queue
  *	@return NULL
  **/
  public function send($array){
    if(is_array($array)){
      $this->m_socket->send(json_encode($array));
    }
  }
  
  /**
  *	Fetch message from the server
  *	@return array
  **/
  public function recv(){
    if($this->m_socket){
      $response = $this->m_socket->recv();
      
      if(is_string($response)){
        return json_decode($response, true);
      }
    }
    
    return false;
  }
}
/*
  $file01 = base64_encode(file_get_contents('plik.txt'));
  $file02 = base64_encode(file_get_contents('plik.txt'));
  
  $paper01 = array('fileName' => 'plagiat.pdf', 'fileContents' => $file01, 'author' => 'Damianek', 'user' => 'Magik', 'time' => time());
  $paper02 = array('fileName' => 'mariusz.pdf', 'fileContents' => $file02, 'author' => 'Mariuszek', 'user' => 'Czarodziej', 'time' => time());
  
  $message = array(
    'headers'   => array('text' => 'Przesylam kilka prac kolego, odbierz!'),
    'requests'  => array('reply_code' => false, 'reply_string' => false),
    'papers'    => array($paper01, $paper02)
  );
  
  $zmq = new ZMQMessage();
  
  // Send message to the server
  $zmq->connect('tcp://127.0.0.1:5555');
  $zmq->send($message);
*/
