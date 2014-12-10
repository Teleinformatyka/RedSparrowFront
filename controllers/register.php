<?php
require_once('lib/zmq.php');
require_once('lib/error.php');

class Register {
  public static function handle($f3){   
    if($f3->exists('POST.submit')){
      $login      = $f3->get('POST.login');
      $password01 = $f3->get('POST.password1');
      $password02 = $f3->get('POST.password2');
      $realname   = $f3->get('POST.name');
      $surname    = $f3->get('POST.surname');
      $email      = $f3->get('POST.email');
      
      if($password01 != $password02){
        return Register::action($f3, Error::PASSWORDS_NOT_EQUAL);
      }
      
      if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        return Register::action($f3, Error::INVALID_EMAIL);
      }
      
      if(!$f3->between($login, $f3->get('username'))){
        return Register::action($f3, Error::INVALID_LOGIN);
      }
      
      if(!$f3->between($password01, $f3->get('password'))){
        return Register::action($f3, Error::INVALID_PASSWORD);
      }
      
      if(!$f3->between($realname, $f3->get('realname'))){
        return Register::action($f3, Error::INVALID_NAME);
      }
      
      if(!$f3->between($surname, $f3->get('surname'))){
        return Register::action($f3, Error::INVALID_SURNAME);
      }
      
      /* Hash */
      $password_md5 = md5($password01);
      
      /* Register */
      $raw = array(
        'jsonrpc' => '2.0', 
        'method' => 'register', 
        'params' => array('login' => $login, 'password' => $password_md5, 'email' => $email, 'name' => $realname, 'surname' => $surname),
        'id' => 1
      );
      
      $msg = new ZMQMessage();
      $msg->send($raw);
      $response = $msg->recv();
      
      if(!is_array($response)){
        return Register::action($f3, Error::INVALID_RESPONSE);
      }
      
      /* Check if response is OK */
      if($response['error']){
        return Register::action($f3, Error::ALREADY_REGISTERED);
      }
      
      return Register::action($f3, Error::NO_ERROR);
    }
    
    /* Register form */
    return Register::render($f3);
  }
  
  public static function action($f3, $code){
    $f3->set('error_code', $code);
    return Register::render($f3);
  }
  
  public static function render($f3){
    echo View::instance()->render('register.html');
  }
}

?>
