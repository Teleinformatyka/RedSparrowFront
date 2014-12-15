<?php

class Index extends StaticClass {
  public static function handle($f3){
    new Session();
    
    if($f3->exists('SESSION.verified')){
      echo Template::instance()->render('index.html');
    } else {
      $f3->reroute('/login');
    }
  }
}

?>