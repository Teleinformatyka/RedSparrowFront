<?php namespace Thesis; use \View as View; use \Session as Session;

class Index {
  public static function handle($f3){
    new Session();
    
    if($f3->exists('SESSION.verified')){
      echo View::instance()->render('showThesesBase.html');
    } else {
      $f3->reroute('/login');
    }
  }
}

?>
