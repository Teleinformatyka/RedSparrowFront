<?php namespace Thesis; use \View as View; use \Session as Session;

class Index {
  public static function handle($f3){
    new Session();
    
    if($f3->exists('SESSION.verified')){
	  echo View::instance()->render('headerTemplate.html');
      echo View::instance()->render('showThesesBase.html');
	  echo View::instance()->render('footerTemplate.html');
    } else {
      $f3->reroute('/login');
    }
  }
}

?>
