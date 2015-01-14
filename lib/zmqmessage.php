<?php

class ZMQMessage {
  private $m_socket;
  
  /**
  *	Construct ZMQ message class
  *	@return NULL
  *	@param $buffer string
  **/
  public function __construct($server = 'tcp://aldorhost.pl:5555'){
    $this->m_socket = new ZMQSocket(new ZMQContext(), ZMQ::SOCKET_REQ);
    
    if($this->m_socket){
      $this->m_socket->setSockOpt(ZMQ::SOCKOPT_SNDTIMEO, 5000);
      $this->m_socket->setSockOpt(ZMQ::SOCKOPT_RCVTIMEO, 5000);
      $this->m_socket->connect($server);
    }
  }
  
  /**
  *	Get database type
  *	@return string
  **/
  public function dbtype(){
    return 'zmq';
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
        while(!is_array($response)){
          $response = json_decode($response, true);
        }
        
        return $response;
      }
    }
    
    return false;
  }
}
