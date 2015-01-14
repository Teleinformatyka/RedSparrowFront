<?php

class Login extends StaticClass {
  public static function handle($f3){
    new Session();
    
    if($f3->exists('POST.submit')){
      $user = User::load($f3->get('POST.login'), $f3->get('POST.password'));
      if($user->exists()){
        /* Session variables */
        $f3->set('SESSION.login', $user->get('login'));
        $f3->set('SESSION.password', $user->get('password'));
        $f3->set('SESSION.verified', true);
      } else {
        /* Error view */
        $f3->set('error', Error::USER_DOES_NOT_EXIST);
        echo Template::instance()->render('error.html'); 
      }
      
      $f3->set('successful', $user->exists());
    }
    
    if($f3->exists('SESSION.verified')){
      $f3->reroute('/thesis');
    } else {
      echo Template::instance()->render('login.html');
    }
  }
}

?>
