<?php

class Index {
  public static function handle($f3){
    $f3->set('variable', 'Test');
    echo View::instance()->render('register.html');
  }
}

?>
