<?php

class Register extends View{

	protected $pageTitle = "Inscription";
	private $css = [];
	private $js = [];

	public function __construct()
	{
		require VIEW . 'elements/session.php';
		ob_start();
		
		if(isset($authorize) && $authorize==1){
            $register_return = 'Vous êtes déjà inscrit sur le site.<br>Revenir à l\'<a href="' . URL . '">Accueil</a>.';
        }

		else if(isset($_POST['submit']) && $_POST['submit']){
			$return='';
			// Verify all inputs
			if(count($_POST)!==5) $return='invalid_form';
            else if($_POST['password']!==$_POST['cpassword']) $return='invalid_match';
            else if(strlen($_POST['login'])<4 || strlen($_POST['login'])>30 || 
					!preg_match("/^[a-zA-Z0-9-_'âàéèêôîûÂÀÉÈÊ ]*$/",$_POST['login'])) $return='invalid_login';
            else if(strlen($_POST['password'])<8 || !self::verifyPwd($_POST['password'])) $return='invalid_password';
            else if(!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL) || !strpos($_POST['mail'], '@laplateforme.io')) $return='invalid_mail';

			// If everything is OK
			else $user = new User($_POST, $return);
			switch($return){
				case 'invalid_form':
				case 'invalid_field':
					$register_return = "Une erreur est survenue dans le traitement de vos données.<br>Veuillez <a href='register'>Réessayer</a>.";
					break;
				case 'invalid_match':
					$register_return = "Les mots de passe ne correspondent pas.<br>Veuillez <a href='register'>Réessayer</a>.";
					break;
				case 'invalid_login':
					$register_return = "Le login n'est pas valide.<br>Veuillez <a href='register'>Réessayer</a>.";
					break;
				case 'invalid_password':
					$register_return = "Le mot de passe n'est pas assez fort.<br>Veuillez <a href='register'>Réessayer</a>.";
					break;
				case 'invalid_mail':
					$register_return = "L'adresse mail n'est pas valide.<br>Veuillez <a href='register'>Réessayer</a>.";
					break;
				case 'allgood':
					switch($user->subscribe()){
						case 'success':
							$mail_address = $user->getHis('mail');
							$message = 'register';
							$login = $user->getHis('login');
							/**
							 * Add crypt ivs etc to db
							 */
							$crypttime=urlencode(openssl_encrypt(time(), $cipher, $key2, OPENSSL_ZERO_PADDING, $iv));
							$link = URL . 'confirm_register&u=' . $user->getHis('id') . '&a=1&t=' . urlencode(md5(time()));
							include ROOT . 'mailer/mailer.php';
							$register_return = "L'inscription a bien été enregistrée. Un e-mail de confirmation va vous être envoyé.<br><a href='" . URL . "'>Accueil</a>";
							break;
						case 'user_exists':
							$register_return = "L'adresse mail ou le nom d'utilisateur est déjà utilisé.<br>Veuillez <a href='register'>Réessayer</a>.";
							break;
						case 'error':
						default:
						$register_return = "Une erreur est survenue dans le traitement de vos données.<br>Veuillez <a href='register'>Réessayer</a>.";
							break;
					}
					break;
				default:
					$register_return = "Une erreur inattendue est survenue.<br>Veuillez <a href='register'>Réessayer</a>.";
					break;
			}
		}
		include './view/user/register.php';

		$this->main[] = ob_get_clean();
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
