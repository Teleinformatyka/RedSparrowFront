<?php

require_once('lib/zmq.php');

class Login {
  public static function handle($f3){
    /*
      $auth = new \Auth(new ZMQMessage());
      //if($f3->exists('POST.submit')){
        if($auth->login('damian', 'damianek')){
        //if($auth->login($f3->get('POST.user'), $f3->get('POST.password'))){
          new Session();
          $f3->set('SESSION.user', 'hh');
          $f3->set('SESSION.password', 'yy');
          $f3->set('SESSION.verified', true);
          
          // Template variables
          $f3->set('verified', true);
          echo "yo";
        } else {
          echo "xx";
        }
      //}
    */
    
    $f3->set('variable', 'Test');
    echo View::instance()->render('login.html');
  }
}

?>
