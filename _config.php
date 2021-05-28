<?php
/*** configuration *****/
ini_set('display_errors','on');
error_reporting(E_ALL);


class MyAutoload
{
	public static function start()
	{

		// Ici on dit à php d'utiliser notre méthode autoload si jamais il rencontre une classe inconnue
		spl_autoload_register(array(__CLASS__, 'autoload'));

		// On défini quelques variables globales qui pourront nous servir pour les liens, les chemins des images, les css, js ....

		//$root = $_SERVER['DOCUMENT_ROOT'];
		//$host = $_SERVER['HTTP_HOST'];

		define('HOST', 'http://localhost/'.__DIR__.'/');
		define('ROOT',  __DIR__.'/');

		define('CONTROLLER', ROOT.'controller/');
		define('VIEW', ROOT.'view/');
		define('MODEL', ROOT.'model/');
		define('CLASSES', ROOT.'classes/');

		define('UPLOADS', ROOT.'uploads');

		define('URL', 'http://localhost/'.basename(getcwd()).'/');

		define('ASSETS', 'http://localhost/'.basename(getcwd()).'/'.'assets/');
		define('CSS', ASSETS.'/'.'css/');
		define('JS', ASSETS. '/'.'js/');
	}


	// La fonction qui est appelée dès qu'une classe inconnue est trouvée
	public static function autoload($class)
	{
		// On va regarder si cette classe ce trouve dans les dossiers Model & Classes & Controller
		self::searchClassInDirectory($class, MODEL);
		self::searchClassInDirectory($class, CLASSES);
		self::searchClassInDirectory($class, CONTROLLER);
	}


	// Ici on recherche le fichier dans un dossier, cette méthode se rappelle elle-même si elle trouve un sous dossier (récursif)
	public static function searchClassInDirectory($class, $directory)
	{
		if ($file = file_exists($directory.$class.'.php')) {
			include_once ($directory.$class.'.php');
			return True;
		}
		else {
			$elements = scandir($directory);
			foreach ($elements as $element) {
				if (is_dir($directory.'/'.$element) && $element !== '.' && $element !== '..') {
					$path = $directory.'/'.$element.'/';
					if (MyAutoload::searchClassInDirectory($class, $path)) {
						return True;
					}
				}
			}
			return False;
		}
	}
}
