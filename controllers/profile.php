<?php

require_once('lib/zmq.php');

class Profile {
  public static function handle($f3){
     $f3->set('variable', 'Test');
    echo View::instance()->render('profile.html');
  }
}

?>
