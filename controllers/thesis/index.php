<?php namespace Thesis; use \View as View; use \Session as Session; use \Template as Template; use \StaticClass as StaticClass;

class Index extends StaticClass {
  public static function handle($f3){
    new Session();
    
    if($f3->exists('SESSION.verified')){
      echo Template::instance()->render('showThesesBase.html');
    } else {
      $f3->reroute('/login');
    }
  }
}

?>
