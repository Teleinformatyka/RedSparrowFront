<?php

class Profile extends StaticClass {
  public static function handle($f3){
    new Session();
    
    if($f3->get('SESSION.verified')){
      $login = $f3->get('SESSION.login');
      $hash  = $f3->get('SESSION.password');
      $user = User::load($login, $hash, false);
      
      if($user->exists()){
        $userlogin = $user->get('login');
        $username = $user->get('name');
        $usersurname = $user->get('surname');
        $level = $user->get('level');
        $email = $user->get('email');

        // set data.
        $f3->set('userlogin', $userlogin);
        $f3->set('usersurname', $usersurname);
        $f3->set('username', $username);
        $f3->set('level', $level);
        $f3->set('email', $email);

        // render profile.html.
        echo Template::instance()->render('profile.html');
      } else {
        $f3->reroute('/error');
      }
    } else {
      // something went wrong.
      $f3->set('error_code', Error::UNABLE_TO_GET_DATA);
      $f3->reroute('/error');
    }
  }
}

?>
