<?php namespace Thesis; use \View as View;

class Add {
  public static function handle($f3){
    $f3->set('variable', 'Test');
    echo View::instance()->render('addThesis.html');
  }
}

?>
