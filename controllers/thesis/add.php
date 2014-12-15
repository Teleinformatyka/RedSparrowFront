<?php namespace Thesis; use \View as View; use \Template as Template;

class Add {
  public static function handle($f3){
    $template = new Template;
    echo $template->render('addThesis.html');
  }
}

?>