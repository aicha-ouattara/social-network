<?php

class Followings extends View{

    protected $pageTitle = "Followings";

    private $css = [];
    private $js = [];

    public function __construct()
	{
        require VIEW . 'elements/session.php';

        ob_start();

        if(isset($_GET['user']) && $_GET['user']){
            $return = '';
            $f_user = new User(['login' => $_GET['user']]);
            $f_user = $f_user->getPublicProfile($return);
            switch($return){
                case 'no_user':
                    $error = ['origin' => 'followings', 'message' => 'Aucun utilisateur du nom de ' . $_GET['user'] . ' n\'a été trouvé.'];
                    include VIEW . 'error.php';
                    break;
                case 'user_found':
                    $followings = $f_user->getFollowingsLogins();
                    include VIEW . 'user/followings.php';
                    break;
                default:
                    $error = ['origin' => 'followings', 'message' => 'Une erreur inattendue est survenue.'];
                    include VIEW . 'error.php';
                    break;
            }
        }
        else{
            $error = ['origin' => 'followings', 'message' => 'Vous ne pouvez pas accéder à la page demandée.'];
            include VIEW . 'error.php';
        }

        $this->main[] = ob_get_clean();
        $this->render();
    }
}