<?php

class Index {
  public static function handle($f3){
    new Session();
    if($f3->exists('SESSION.verified')){
      $template = new Template;
      echo $template->render('index.html');
    } else {
      $f3->reroute('/login');
    }
  }
}

?>