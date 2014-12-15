<?php

class ErrorView extends StaticClass {
  public static function handle($f3) {
    echo Template::instance()->render('error.html');
  }
}

?>