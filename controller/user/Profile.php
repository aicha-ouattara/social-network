<?php

class Profile extends View{
    
    protected $pageTitle = 'Profil';
    private $css = [];
    private $js = [];

    public function __construct()
	{
        require VIEW . 'elements/session.php';

        /**
         * Replace all echos with specifics views
         */
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
                        $this->main[] = "Aucun utilisateur du nom de " . $_GET['user'] . " n'a été trouvé.";
                        break;
                    case 'user_found':
                        include VIEW . 'user/visit_profile.php';
                        break;
                    default:
                        $this->main[] = "Une erreur inattendue est survenue.";
                        break;
                }
            }
        }
        
        else if(!isset($authorize) || $authorize!==1){
            $this->main[] = "Vous devez vous connecter.";
        }

        else{
            include VIEW . 'user/profile.php';
        }

        $this->main[] = ob_get_clean();
        $this->render();
    }
}