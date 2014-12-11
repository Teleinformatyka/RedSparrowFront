<?php
require_once('lib/error.php');
require_once('lib/zmq.php');

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
        'email'     => array('min' => 0, 'max' => 32, 'error' => Error::INVALID_EMAIL, 'validate' => function($v, $min, $max){return filter_var($v, FILTER_VALIDATE_EMAIL);}),
        'name'      => array('min' => 2, 'max' => 32, 'error' => Error::INVALID_NAME, 'validate' => function($v, $min, $max){return preg_match('/^[A-Z][a-z]{'.$min.','.$max.'}$/', $v) == 1;}),
        'surname'   => array('min' => 2, 'max' => 32, 'error' => Error::INVALID_SURNAME, 'validate' => function($v, $min, $max){return preg_match('/^[A-Z][a-z]{'.$min.','.$max.'}$/', $v) == 1;})
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
      'id' => 1
    );
    
    $zmq = new ZMQMessage();
    $zmq->send($raw);
    
    $response = $zmq->recv();
    if($response['id'] == $raw['id'] && $response['error'] == NULL){
      $this->m_vars['login']    = $response['result']['login'];
      $this->m_vars['password'] = $response['result']['password'];
      $this->m_vars['email']    = $response['result']['email'];
      $this->m_vars['name']     = $response['result']['name'];
      $this->m_vars['surname']  = $response['result']['surname'];
      $this->m_vars['theses']   = $response['result']['theses'];
      $this->m_vars['levels']   = $response['result']['levels'];
    
      $this->m_exists = true;
    }
  }
  
  private function __save(){
    /* Save using ZMQ message */  
    $raw = array();
    
    if($this->m_exists){
      // TODO
    } else {
      $raw = array(
        'jsonrpc' => '2.0',
        'method'  => 'register',
        'params'  => array(
          'login'     => $this->m_vars['login'], 
          'password'  => $this->m_vars['password'], 
          'email'     => $this->m_vars['email'], 
          'name'      => $this->m_vars['name'], 
          'surname'   => $this->m_vars['surname']
        ),
        'id' => 1
      );
    }
    
    $zmq = new ZMQMessage();
    $zmq->send($raw);
    
    $response = $zmq->recv();
    if($response['id'] == $raw['id'] && $response['error'] == NULL){
      $this->m_exists = true;
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
  
  public static function load($login, $password){
    $object = new User();
    
    $object->m_vars['login']    = $login;
    $object->m_vars['password'] = $object->__hash($password);
    
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
        
        if(isset($validator['validate'])){
          if(!$validator['validate']($v, $validator['min'], $validator['max'])){
            $error = $validator['error'];
          }
        } else if(strlen($v) < $validator['min'] || strlen($v) > $validator['max']){
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
}

?>