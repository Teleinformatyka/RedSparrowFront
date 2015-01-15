<?php
  $f3 = require('lib/base.php');
  $f3->config('config.ini');
  
  $f3->set('DEBUG', 1);
  $f3->set('AUTOLOAD', 'controllers/ ; models/');
  $f3->set('CACHE', 'memcache=localhost');
  
  /* Routers */
  $f3->route('GET|POST /', 'Index::handle');
  $f3->route('GET|POST /login', 'Login::handle');
  $f3->route('GET|POST /logout', 'Logout::handle');
  $f3->route('GET|POST /register', 'Register::handle');
  $f3->route('GET|POST /profile', 'Profile::handle');
  $f3->route('GET|POST /thesis', 'Thesis\Index::handle');
  $f3->route('GET|POST /thesis/add', 'Thesis\Add::handle');
  
  
  /* Route requests for UI elements (css, javascript, and so on) to valid directory */
  $f3->route('GET */ui/*', function($f3, $params) { 
      $f3->reroute('/ui/' . $params[2]); 
    }
  );
  
  $f3->run();
?>
