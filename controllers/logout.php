<?php

class Logout extends StaticClass {
  public static function handle($f3){
    new Session();
    
    $f3->clear('SESSION');
    $f3->reroute('/login');
  }
}

?>
