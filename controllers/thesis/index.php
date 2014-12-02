<?php namespace Thesis; use \View as View;

class Index {
  public static function handle($f3){
    $f3->set('variable', 'Test');
    echo View::instance()->render('showThesesBase.html');
  }
}

?>
