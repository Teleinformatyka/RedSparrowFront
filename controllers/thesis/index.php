<?php namespace Thesis; use \View as View; use \Session as Session; use \Template as Template;

class Index {
  public static function handle($f3){
    new Session();
    
    if($f3->exists('SESSION.verified')){
      $template = new Template;
      echo $template->render('showThesesBase.html');
    } else {
      $f3->reroute('/login');
    }
  }
}

?>
