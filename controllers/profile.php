<?php

class Profile extends StaticClass {
  public static function handle($f3){
    new Session();
    
    if($f3->get('SESSION.verified')){
      $login = $f3->get('SESSION.login');
      $hash = $f3->get('SESSION.password');  
      $user = User::load($login, $hash, false);  
      
      if($user->exists()){
        /* Template variables */
        $f3->set('userlogin', $user->get('login'));
        $f3->set('usersurname', $user->get('name'));
        $f3->set('username', $user->get('surname'));
        $f3->set('email', $user->get('email'));
        
        if($f3->get('POST.edit')){
          $user->set('name', $f3->get('POST.newname'));
          $user->set('surname', $f3->get('POST.newsurname'));
          $user->set('email', $f3->get('POST.newemail'));
          
          /* Save user */
          $f3->set('error', $user->save());
        }

        echo Template::instance()->render('profile.html');
      } else {
        $f3->reroute('/logout');
      }
    } else {
      /* You are not logged in */
      $f3->reroute('/login');
    }
  }
}

?>
