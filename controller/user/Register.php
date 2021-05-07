<?php

class Register extends View{

	private $pageTitle = "Inscription";

	private $css = [];
	private $js = [];

	public function __construct()
	{
		if(isset($_POST['submit']) && $_POST['submit']){
			$return='';
			$sub = new Subscription($_POST, $return);
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
					switch($sub->subscribe()){
						case 'success':
							echo "L'inscription a bien été enregistrée.";
							break;
						case 'user_exists':
							echo "L'adresse mail ou le nom d'utilisateur est déjà utilisé.";
							break;
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
}
