 <?php
/**
* Class Routeur
*
* create routes and find controller
*/
class Routeur
{
	// Liste des pages et de leurs controllers
	private $controllers = [
		""					=> 'Home',
		"home"				=> 'Home',
		"register"			=> 'Register',
		"connection"		=> 'Connect',
		"connect" 			=> 'Connect',
		"profil"			=> 'Profile',
		"settings"			=> 'Settings',
		"informations"		=> 'Informations',
		"messages"			=> 'Messages',
		"delete"			=> 'Delete',
		"friends"			=> 'Friends',
		"test"				=> 'Test',
		"post"				=> 'PostManager',
		"likes"				=> 'LikeManager',
		"comments"			=> 'CommentManager',
		"reaction"			=> 'PostReactionManager',
	];
	private $controller;	// Controleur sélectionné


	public function __construct()
	{
		// Choix du controleur
		if ($this->controller = $this->selectController($this->controllers));
		// Si le controleur n'existe pas on redirige
		else {
			echo "erreur 404 -> La page que vous voulez consulter n'existe pas.";
		}
	}


	public function selectController($controllers)
	{
		if(key_exists($_SESSION['url'][0], $controllers))
		{
			$controller = $controllers[$_SESSION['url'][0]];

			return new $controller();
		}
		else {
			return False;
		}
	}


	// public function cleanUrl()
	// {
	// 	if (isset($_SESSION['url'][0])) {
	// 		\array_splice($_SESSION['url'], 0, 1);
	// 	}
	// }
}
