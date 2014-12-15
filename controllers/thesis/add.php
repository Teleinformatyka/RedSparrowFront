<?php namespace Thesis; use \View as View; use \Session as Session; use \Template as Template; use \StaticClass as StaticClass;

class Add extends StaticClass {
  public static function handle($f3){
    echo Template::instance()->render('addThesis.html');
  }
}

?>