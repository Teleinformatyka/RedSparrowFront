<?php

class Thesis {
  private $m_vars;
  private $m_exists;
  
  private function __load(){
    /* Load using ZMQ message */
    $raw = array(
      'jsonrpc' => '2.0',
      'method'  => 'thesisdetailsmethods-get_thesis_details_by_thesis_id',
      'params'  => array(
        'thesisId'  => $this->m_vars['id'],
      ),
      'id' => mt_rand(1, 65537)
    );
    
    $zmq = new ZMQMessage();
    $zmq->send($raw);
    
    $response = $zmq->recv();
    if($response['id'] == $raw['id'] && $response['error'] == NULL){
      $this->m_vars = $response['result'];
      $this->m_exists = true;
    }
  }
  
  private function __save(){
    /* Save using ZMQ message */  
    $messages = array();
    
    if($this->m_exists){
      foreach($this->m_vars as $key => $value){
        $messages[] = array(
          'jsonrpc' => '2.0', 
          'method' => 'thesismethods-edit_thesis', 
          'params' => array('columnName' => $key, 'value' => $value, 'thesisId' => $this->get('id')),
          'id' => mt_rand(1, 65537)
        );
      }
    } else {
      $messages[] = array(
          'jsonrpc' => '2.0', 
          'method' => 'thesismethods-add_thesis', 
          'params' => array(
            'thesis_name'   => $this->m_vars['thesis_name'],
            'user_id'       => $this->m_vars['user_id'],
            'supervisor_id' => $this->m_vars['supervisor_id'],
            'fos_id'        => $this->m_vars['fos_id'],
            'filepath'      => $this->m_vars['filepath']
          ),
          'id' => mt_rand(1, 65537)
        );
    }
    
    $zmq = new ZMQMessage();
    foreach($messages as $message){
      $zmq->send($message);    
      $response = $zmq->recv();
      
      if($response['id'] == $message['id'] && $response['error'] == NULL){
        $this->m_exists = true;
      } else {
        break;
      }
    }
    
    return $this->m_exists ? Error::NO_ERROR : Error::INVALID_RESPONSE;
  }
  
  /* Public static functions */
  
  public static function getListOfThesesByUserId($userId){
    $message = array(
      'jsonrpc' => '2.0',
      'method' => 'thesismethods-get_thesis_by_user_id',
      'params' => array('userId' => $userId),
      'id' => mt_rand(1, 65537)
    );
    
    $zmq = new ZMQMessage();
    $zmq->send($message);    
    $response = $zmq->recv();
    
    if($response['id'] == $message['id'] && $response['error'] == NULL){
      return $response['result']['theses'];
    }
    
    return array();
  }
  
  public static function getListOfTheses(){
    $message = array(
      'jsonrpc' => '2.0',
      'method' => 'thesismethods-get_list_of_thesis',
      'params' => array(),
      'id' => mt_rand(1, 65537)
    );
    
    $zmq = new ZMQMessage();
    $zmq->send($message);    
    $response = $zmq->recv();
    
    if($response['id'] == $message['id'] && $response['error'] == NULL){
      return $response['result']['theses'];
    }
    
    return array();
  }

  public static function getAmountOfTheses(){
    $message = array(
      'jsonrpc' => '2.0',
      'method' => 'thesismethods-get_list_of_thesis',
      'params' => array(),
      'id' => mt_rand(1, 65537)
    );
    
    $zmq = new ZMQMessage();
    $zmq->send($message);    
    $response = $zmq->recv();
    
    if($response['id'] == $message['id'] && $response['error'] == NULL){
      return $response['result'];
    }
    
    return 0;
  }
}

?>