<?php

class Login {
  public static function handle($f3){
    $f3->set('variable', 'Test');
    echo View::instance()->render('login.html');
  }
}

?>
