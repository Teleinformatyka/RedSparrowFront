<?php
require_once('lib/zmq.php');
class ErrorView {
  public static function handle($f3) {
  	 $f3->set('variable', 'Test');
	 echo View::instance()->render('headerTemplate.html');
     echo View::instance()->render('error.html');
	 echo View::instance()->render('footerTemplate.html');
  }
}

?>