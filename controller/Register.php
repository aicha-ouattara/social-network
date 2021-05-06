<?php

/**
 *
 */
class Register extends View
{
	// Il faut donner le titre de la page
	private $pageTitle = "Inscription";

	// Il faut donner la liste des css et js à lier
	private $css = [];
	private $js = [];

	function __construct()
	{
		// Il faut remplir la variable $main des différents contenus du main (d'où la liste)
		// Cela va nous permettre de travailler par petits modules qu'on pourrait répéter ailleurs

		$this->main[] = file_get_contents('./view/register.php');

		//On rend directement la page avec la méthode "render"
		$this->render();
	}
}
