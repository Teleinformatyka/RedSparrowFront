<?php

require_once('lib/zmq.php');

require_once('lib/error.php');

require_once('models/user.php');

// Profile class.
class Profile {

   // Default constructor.
   public function __construct(){
   	 // Get user from session.
   	 
   }

  // handle function.
  public static function handle($f3) {
     $f3->set('variable', 'Test');
     // $f3->set('username',  $f3->get('SESSION.user'));
    // $f3->set('level','SESSION.user.level');
    //$f3->set('email','SESSION.user.email');
    $f3->set('username',  'Jan Kowalski');
    $f3->set('level','Promotor');
    $f3->set('email','kowalski@jan.com');
     // render profile.html.
    echo View::instance()->render('profile.html');
  }
}

?>
