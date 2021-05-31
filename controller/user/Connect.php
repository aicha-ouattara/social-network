<?php

class Connect extends View{
    
    protected $pageTitle = "Connexion";

    private $css = [];
    private $js = [];

    public function __construct()
	{
        require VIEW . 'elements/session.php';

        ob_start();
        if(isset($authorize) && $authorize==1){
           $connect_return = "Vous êtes déjà connecté.";
        }

		else if(isset($_POST['submit']) && isset($_POST['login']) && isset($_POST['password'])){
            $return = '';
            if(count($_POST)!==3) $return='invalid_form';
            else $user = new User($_POST, $return);

            switch($return){
                case 'invalid_form':
                    $connect_return = "Une erreur est survenue dans le traitement de vos données.<br><a href='connection'>Réessayer</a>";
					break;
                case 'allgood':
                    switch($user->connect()){
                        case 'connected':
                            $connect_return = "Vous êtes maintenant connecté.<br><a href='" . URL  . "'>Accueil</a>";
                            break;
                        case 'bad_login':
                            $connect_return = "Login ou mot de passe incorrect.<br><a href='connection'>Réessayer</a>";
                            break;
                        case 'bad_ip':
                            $connect_return = "Vous tentez de vous connecter depuis un nouvel appareil. Veuillez suivre le lien de confirmation envoyé sur l'adresse mail 
                            renseignée.";
                            break;
                        case 'inactive':
                            $connect_return = "Votre compte n'est pas encore actif. Si vous venez de créer votre compte, veuillez suivre le lien d'activation envoyé sur 
                            l'adresse mail renseignée. Sinon, contactez le support à support@okkonetwork.com .";
                            break;
                        default:
                            $connect_return = "Une erreur inattendue est survenue.<br><a href='connection'>Réessayer</a>";
                            break;
                    }
                    break;
                default:
                    $connect_return = "Une erreur inattendue est survenue.<br><a href='connection'>Réessayer</a>";
                    break;
            }
        }

        include './view/user/connect.php';
        $this->main[] = ob_get_clean();

        $this->render();
    }
}