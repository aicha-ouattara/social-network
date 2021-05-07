<?php

class Connect extends View{
    
    private $pageTitle = "Connexion";

    private $css = [];
    private $js = [];

    public function __construct()
	{
		if(isset($_POST['submit']) && $_POST['submit']){
            $return = '';
            if(count($_POST)!==3) $return='invalid_form';
            else $user = new User($_POST, $return);

            switch($return){
                case 'invalid_form':
                    echo "Une erreur est survenue dans le traitement de vos données.";
					break;
                case 'allgood':
                    switch($user->connect()){
                        case 'connected':
                            echo "Vous êtes maintenant connecté.";
                            break;
                        case 'bad_login':
                            echo "Login ou mot de passe incorrect.";
                            break;
                        case 'bad_ip':
                            echo "Vous tentez de vous connecter depuis un nouvel appareil. Veuillez suivre le lien de confirmation envoyé sur l'adresse mail 
                            renseignée.";
                            break;
                        case 'inactive':
                            echo "Votre compte n'est pas encore actif. Si vous venez de créer votre compte, veuillez suivre le lien d'activation envoyé sur 
                            l'adresse mail renseignée. Sinon, contactez le support à support@okkonetwork.com .";
                            break;
                        default:
                            echo "Une erreur inattendue est survenue";
                            break;
                    }
                    break;
                default:
                    echo "Une erreur inattendue est survenue";
                    break;
            }
        }

        else include './view/user/connect.php';
        $this->main[] = '';

        $this->render();
    }
}