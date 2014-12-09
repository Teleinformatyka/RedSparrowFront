<?php
require_once('lib/zmq.php');

class Register {
  const
    MIN_LOGIN_LENGTH     = 6,
    MAX_LOGIN_LENGTH     = 32,
    MIN_PASSWORD_LENGTH  = 6,
    MAX_PASSWORD_LENGTH  = 32,
    MIN_NAME_LENGTH      = 6,
    MAX_NAME_LENGTH      = 32,
    MIN_SURNAME_LENGTH   = 6,
    MAX_SURNAME_LENGTH   = 32;
    
  const
    ERROR_NOT_EVERYTHING_ISSET = 1,
    ERROR_PASSWORDS_NOT_EQUAL  = 2,
    ERROR_INVALID_EMAIL        = 3,
    ERROR_INVALID_LOGIN        = 4,
    ERROR_INVALID_PASSWORD     = 5,
    ERROR_INVALID_NAME         = 6,
    ERROR_INVALID_SURNAME      = 7,
    ERROR_INVALID_RESPONSE     = 8;
    
  public static function handle($f3){   
    if($f3->exists('POST.submit')){
      $login =      $f3->get('POST.login');
      $password01 = $f3->get('POST.login');
      $password02 = $f3->get('POST.login');
      $name =       $f3->get('POST.name');
      $surname =    $f3->get('POST.surname');
      $email =      $f3->get('POST.email');
      
      if($password01 != $password02){
        return Register::error($f3, Register::ERROR_PASSWORDS_NOT_EQUAL);
      }
      
      if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        return Register::error($f3, Register::ERROR_INVALID_EMAIL);
      }
      
      if(strlen($login) < Register::MIN_LOGIN_LENGTH || strlen($login) > Register::MAX_LOGIN_LENGTH){
        return Register::error($f3, Register::ERROR_INVALID_LOGIN);
      }
      
      if(strlen($password01) < Register::MIN_PASSWORD_LENGTH || strlen($password01) > Register::MAX_PASSWORD_LENGTH){
        return Register::error($f3, Register::ERROR_INVALID_PASSWORD);
      }
      
      if(strlen($name) < Register::MIN_NAME_LENGTH || strlen($name) > Register::MAX_NAME_LENGTH){
        return Register::error($f3, Register::ERROR_INVALID_NAME);
      }
      
      if(strlen($surname) < Register::MIN_SURNAME_LENGTH || strlen($surname) > Register::MAX_SURNAME_LENGTH){
        return Register::error($f3, Register::ERROR_INVALID_SURNAME);
      }
      
      /* Hash */
      $password_md5 = md5($password01);
      
      /* Register */
      $raw = array(
        'jsonrpc' => '2.0', 
        'method' => 'register', 
        'params' => array('login' => $login, 'password' => $password_md5, 'email' => $email, 'name' => $name, 'surname' => $surname),
        'id' => 1
      );
      
      $msg = new ZMQMessage();
      $msg->send($raw);
      $response = $msg->recv();
      
      if(!is_array($response)){
        return Register::error($f3, Register::ERROR_INVALID_RESPONSE);
      }
      
      /* Check if response is OK */
      echo print_r($response);
    }
    
    echo View::instance()->render('register.html');   
  }
  
  public static function error($f3, $code){
    $f3->set('error', $code);
    echo View::instance()->render('register.html');
  }
}

?>
