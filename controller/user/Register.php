<?php

class Register extends View{

	protected $pageTitle = "Inscription";
	private $css = [];
	private $js = [];

	public function __construct()
	{
		require VIEW . 'elements/session.php';

		/**
         * Replace all echos with specifics views
         */
		
		if(isset($authorize) && $authorize==1){
            echo "Vous êtes déjà inscrit.";
        }

		else if(isset($_POST['submit']) && $_POST['submit']){
			$return='';

			/**
             * Verify all inputs
             */

			if(count($_POST)!==5) $return='invalid_form';
            else if($_POST['password']!==$_POST['cpassword']) $return='invalid_match';
            else if(strlen($_POST['login'])<4 || strlen($_POST['login'])>30 || 
					!preg_match("/^[a-zA-Z0-9-_'âàéèêôîûÂÀÉÈÊ ]*$/",$_POST['login'])) $return='invalid_login';
            else if(strlen($_POST['password'])<8 || !self::verifyPwd($_POST['password'])) $return='invalid_password';
            else if(!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL) || !strpos($_POST['mail'], '@laplateforme.io')) $return='invalid_mail';

			/**
             * If everything's in order
             */
			
			else $user = new User($_POST, $return);

			/**
			 * Action on $return value
			 */
			switch($return){
				case 'invalid_form':
				case 'invalid_field':
					echo "Une erreur est survenue dans le traitement de vos données.";
					break;
				case 'invalid_match':
					echo "Les mots de passe ne correspondent pas.";
					break;
				case 'invalid_login':
					echo "Le login n'est pas valide.";
					break;
				case 'invalid_password':
					echo "Le mot de passe n'est pas assez fort.";
					break;
				case 'invalid_mail':
					echo "L'adresse mail n'est pas valide.";
					break;
				case 'allgood':
					switch($user->subscribe()){
						case 'success':
							echo "L'inscription a bien été enregistrée.";
							break;
						case 'user_exists':
							echo "L'adresse mail ou le nom d'utilisateur est déjà utilisé.";
							break;
						case 'error':
						default:
							echo "Une erreur est survenue dans le traitement de vos données.";
							break;
					}
					break;
				default:
					echo "Une erreur inattendue est survenue";
					break;
			}
		}
		
		else include './view/user/register.php';

		$this->main[] = '';
		
		
		$this->render();
	}

	public function verifyPwd(string $password){
		if( !preg_match('@[A-Z]@', $password) || !preg_match('@[a-z]@', $password) ||
			!preg_match('@[0-9]@', $password) || !preg_match('@[^\w]@', $password) ||
			strlen($password)<8 ){
				return 0;
			}
		else{
			return 1;
		}
	}

}
