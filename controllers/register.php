<?php
require_once('lib/zmq.php');
require_once('lib/error.php');

require_once('models/user.php');

class Register {
  public static function handle($f3){
    if($f3->exists('POST.submit')){
      if($f3->get('POST.password1') != $f3->get('POST.password2')){
        return Register::action($f3, Error::PASSWORDS_NOT_EQUAL);
      }
      
      /* Create user */
      $user = User::create($f3->get('POST.login'), $f3->get('POST.password1'), $f3->get('POST.email'), $f3->get('POST.name'), $f3->get('POST.surname'));
      
      /* Register user with save function */
      return Register::action($f3, $user->save());
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
