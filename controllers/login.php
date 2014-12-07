<?php

require_once('lib/zmq.php');

class Login {
  public static function handle($f3){
    new Session();
    $auth = new \Auth(new ZMQMessage());
    
    if($f3->exists('POST.submit')){
      $f3->set('attempt', true);
      if($auth->login($f3->get('POST.login'), $f3->get('POST.password'))){
        /* Session variables */
        $f3->set('SESSION.user', $f3->get('POST.login'));
        $f3->set('SESSION.password', $f3->get('POST.password'));
        $f3->set('SESSION.verified', true);
        
        /* Template variables */
        $f3->set('successful', true);
      } else {
        /* Template variables */
        $f3->set('successful', false);
      }
    }
    
    if($f3->exists('SESSION.verified')){
      $f3->reroute('/thesis');
    } else {
      echo View::instance()->render('login.html');
    }
  }
}

?>
