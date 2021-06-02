<?php

class Profile extends View{
    
    protected $pageTitle = 'Profil';
    private $css = [];
    private $js = [];

    public function __construct()
	{
        require VIEW . 'elements/session.php';
        ob_start();

        if(isset($_GET['user']) && $_GET['user']){
            $return = '';
            $visit_user = new User(['login' => $_GET['user']]);
            if(isset($authorize) && $authorize==1 && $user->getHis('login') == $_GET['user']){
                include VIEW . 'user/profile.php';
            }
            else{
                $visit_user = $visit_user->getPublicProfile($return);
                switch($return){
                    case 'no_user':
                        $error = ['origin' => 'profile', 'message' => 'Aucun utilisateur du nom de ' . $_GET['user'] . ' n\'a été trouvé.'];
                        include VIEW . 'error.php';
                        break;
                    case 'user_found':
                        $this->jsList[] = 'follow.js';
                        include VIEW . 'user/visit_profile.php';
                        break;
                    default:
                        $error = ['origin' => 'profile', 'message' => 'Une erreur inattendue est survenue.'];
                        include VIEW . 'error.php';
                        break;
                }
            }
        }
        
        else if(!isset($authorize) || $authorize!==1){
            $error = ['origin' => 'profile', 'message' => 'Vous devez vous connecter pour accéder à cette page.<br><a href="connection">Se connecter</a>.'];
            include VIEW . 'error.php';
        }

        else{
            if(isset($_POST['disconnect']) && $_POST['disconnect']==1){
                setcookie('authtoken', '', -1, '/');
                header('Location:' . URL);
            }
            else include VIEW . 'user/profile.php';
        }

        $this->main[] = ob_get_clean();
        $this->render();
    }
}