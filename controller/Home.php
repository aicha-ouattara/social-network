<?php

/**
 *
 */
class Home extends View
{
	// Il faut donner le titre de la page
	protected $pageTitle = "Home";

	// Il faut donner la liste des css et js à lier
	// public $cssList = [];
	// public $jsList = [];

	function __construct()
	{
		// Il faut remplir la variable $main des différents contenus du main (d'où la liste)
		// Cela va nous permettre de travailler par petits modules qu'on pourrait répéter ailleurs

        ob_start();

        $this->main[] = ob_get_clean();

		

		//On rend directement la page avec la méthode "render"
		$this->render();
	}
}
