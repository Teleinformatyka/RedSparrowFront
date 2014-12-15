<?php

class Index {
  public static function handle($f3){
    new Session();
    if($f3->exists('SESSION.verified')){
		$f3->set('nav', View::instance()->render('navigationTemplate.html'));
		echo View::instance()->render('headerTemplate.html');
		echo View::instance()->render('index.html');
		echo View::instance()->render('footerTemplate.html');
    } else {
      $f3->reroute('/login');
    }
  }
}

?>