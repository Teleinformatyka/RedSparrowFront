<?php namespace Thesis; use \View as View; use \Session as Session; use \Template as Template; use \StaticClass as StaticClass; use \Thesis as ThesisModel;

class Index extends StaticClass
{
    public static function handle($f3)
    {
        new Session();

        if ($f3->get('SESSION.verified')) {
            $login = $f3->get('SESSION.login');
            $hash = $f3->get('SESSION.password');
            $user = User::load($login, $hash, false);

            if ($user->exists()) {
                /* Template variables */
                $theseesBase = ThesisModel::getListOfThesesByUserId($user->get('id'));
                $f3->set('theseesBase', $theseesBase);

                echo Template::instance()->render('showThesesBase.html');
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
