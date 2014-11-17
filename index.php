<?php
  $f3 = require('lib/base.php');
  $f3->set('DEBUG', 1);

  if ((float)PCRE_VERSION<7.9){
    trigger_error('PCRE version is out of date');
  }

  $f3->config('config.ini');

  $f3->route('GET /',
    function($f3) {
      $f3->set('logo', 'redsparrow.png');
      //$f3->set('content','index.htm');
      echo View::instance()->render('index.html');
    }
  );

  $f3->route('GET /login',
    function($f3) {
      //$f3->set('content','subpage.htm');
      echo View::instance()->render('login.htmy');
    }
  );

  $f3->run();
?>
