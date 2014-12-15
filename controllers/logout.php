<?php
require_once('lib/zmq.php');

require_once('models/user.php');

class Login {
  public static function handle($f3){
    new Session();
    
	$f3->clear('SESSION');
	$f3->reroute('/login');
  }
}

?>
