<?php

class User {
  private $validator;
  private $m_vars;
  private $m_exists;
  
  private function __construct(){
    $this->m_exists = false;
    $this->m_vars = array();   
    $this->validator = 
      array( 
        'login'     => array('min' => 3, 'max' => 32, 'error' => Error::INVALID_LOGIN),
        'password'  => array('min' => 3, 'max' => 32, 'error' => Error::INVALID_PASSWORD),
        'email'     => array('min' => 0, 'max' => 32, 'error' => Error::INVALID_EMAIL, 'procedure' => function($v, $min, $max){return filter_var($v, FILTER_VALIDATE_EMAIL);}),
        'name'      => array('min' => 2, 'max' => 32, 'error' => Error::INVALID_NAME, 'procedure' => function($v, $min, $max){return preg_match('/^[A-Z][a-z]{'.$min.','.$max.'}$/', $v) == 1;}),
        'surname'   => array('min' => 2, 'max' => 32, 'error' => Error::INVALID_SURNAME, 'procedure' => function($v, $min, $max){return preg_match('/^[A-Z][a-z]{'.$min.','.$max.'}$/', $v) == 1;})
      );
  }
  
  private function __hash($v){
    return md5($v);
  }
  
  private function __load(){
    /* Load using ZMQ message */
    $raw = array(
      'jsonrpc' => '2.0',
      'method'  => 'login',
      'params'  => array(
        'login'     => $this->m_vars['login'],
        'password'  => $this->m_vars['password']
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
          'method' => 'usermethods-edit_user', 
          'params' => array('columnName' => $key, 'value' => $value, 'userId' => $this->get('id')),
          'id' => mt_rand(1, 65537)
        );
      }
    } else {
      $messages[] = array(
        'jsonrpc' => '2.0',
        'method'  => 'register',
        'params'  => array(
          'login'     => $this->m_vars['login'], 
          'password'  => $this->m_vars['password'], 
          'email'     => $this->m_vars['email'], 
          'name'      => $this->m_vars['name'], 
          'surname'   => $this->m_vars['surname']
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
  
  public static function create($login, $password, $email, $name, $surname){
    $object = new User();
    
    $object->m_vars['login']    = $login;
    $object->m_vars['password'] = $object->__hash($password);
    $object->m_vars['email']    = $email;
    $object->m_vars['name']     = $name;
    $object->m_vars['surname']  = $surname;
    
    return $object;
  }
  
  public static function load($login, $password, $hash = true){
    $object = new User();
    
    $object->m_vars['login']    = $login;
    $object->m_vars['password'] = $hash ? $object->__hash($password) : $password;
    
    $object->__load();
    
    return $object;
  }
  
  public function set($key, $value){
    if(isset($this->m_vars[$key])){
      if($key == 'password'){
        $value = $this->__hash($value);
      }
      
      $this->m_vars[$key] = $value;
      return true;
    }
    
    return false;
  }
  
  public function get($key){
    if(isset($this->m_vars[$key])){
      return $this->m_vars[$key];
    }
    
    return NULL;
  }
  
  public function save(){
    $error = Error::NO_ERROR;
    
    /* Validate here */  
    foreach($this->m_vars as $k => $v){
      if(isset($this->validator[$k])){
        $validator = $this->validator[$k];
        
        /* Validator internal limits */
        $min = $validator['min'];
        $max = $validator['max'];
        
        $validate = function($v, $min, $max){
          if(strlen($v) < $min || strlen($v) > $max){
            return false;
          }
          
          return true;
        };
        
        if(isset($validator['procedure'])){
          $validate = $validator['procedure'];
        }
        
        if(!$validate($v, $min, $max)){
          $error = $validator['error'];
        }
      }
      
      if($error != Error::NO_ERROR){
        break;
      }
    }
    
    if($error == Error::NO_ERROR){
      return $this->__save();
    }
    
    return $error;
  }
  
  public function exists(){
    return $this->m_exists;
  }
  
  /* Public static functions */
  
  public static function getListOfUsers(){
    $message = array(
      'jsonrpc' => '2.0',
      'method' => 'usermethods-get_list_of_users',
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

  public static function getAmountOfUsers(){
    $message = array(
      'jsonrpc' => '2.0',
      'method' => 'usermethods-get_numer_of_users',
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
