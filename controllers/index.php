<?php

class Index extends StaticClass {
  public static function handle($f3){
    new Session();
    
    if($f3->exists('SESSION.verified')){
      /* Populate page */
      $f3->set('users', User::getAmountOfUsers());
      $f3->set('theses', Thesis::getAmountOfTheses());
      /* Render template */
      echo Template::instance()->render('index.html');
    } else {
      $f3->reroute('/login');
    }
  }
}

?>