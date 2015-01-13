<?php

class Register extends StaticClass {
  public static function handle($f3){
    if($f3->exists('POST.submit')){
      if($f3->get('POST.password1') != $f3->get('POST.password2')){
        $f3->set('error_code', Error::PASSWORDS_NOT_EQUAL);
      } else {      
        /* Create user */
        $user = User::create($f3->get('POST.login'), $f3->get('POST.password1'), $f3->get('POST.email'), $f3->get('POST.name'), $f3->get('POST.surname'));
        
        /* Register user with save function */;
        $f3->set('error_code', $user->save());
      }
    }
	else
	{
	  /* Register form */
	  echo Template::instance()->render('register.html');
	}
    
    if($f3->get('error_code') === Error::NO_ERROR){
      /* Re-route to login form */
      $f3->reroute('/login');
    } else {  
      /* Error view */
	  $f3->set('error', "Podczas rejestracji podano niepoprawne dane.");
      echo Template::instance()->render('error.html'); 
    }
  }
}

?>
