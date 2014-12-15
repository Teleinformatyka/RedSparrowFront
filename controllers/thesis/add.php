<?php namespace Thesis; use \View as View;

class Add {
  public static function handle($f3){
    $f3->set('variable', 'Test');
	$f3->set('nav', View::instance()->render('navigationTemplate.html'));
	echo View::instance()->render('headerTemplate.html');
    echo View::instance()->render('addThesis.html');
	echo View::instance()->render('footerTemplate.html');
  }
}

?>