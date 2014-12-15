<?php
require_once('lib/zmq.php');
class ErrorView {
  public static function handle($f3) {
    $f3->set('variable', 'Test');
    $template = new Template;
    echo $template->render('error.html');
  }
}

?>