<?php namespace Thesis; use \View as View; use \Session as Session; use \Template as Template; use \StaticClass as StaticClass; use \User as UserModel; use \Thesis as ThesisModel; use \Error as Error;

class Add extends StaticClass {
  public static function handle($f3){
    new Session();

    if($f3->get('SESSION.verified')){
      $login = $f3->get('SESSION.login');
      $hash = $f3->get('SESSION.password');
      $user = UserModel::load($login, $hash, false);

      if($user->exists()){
        if($f3->exists('POST.submit')){
          $name = $f3->get('POST.name');

          if(isset($_FILES['fileToUpload'])){
            $path = $_FILES['fileToUpload']['tmp_name'];

            /* Create new document */
            $document = ThesisModel::create($name, $user->get('id'), $user->get('id'), 1, $path);

            /* Save document */
            $f3->set('error', $document->save());
          } else {
            $f3->set('error', Error::NO_FILE_UPLOADED);
          }
        }

        echo Template::instance()->render('addThesis.html');
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