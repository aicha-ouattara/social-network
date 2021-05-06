<?php

/**
 *
 */
class Friends extends View
{
	// Il faut donner le titre de la page
	public $pageTitle = "Friends";

	// Il faut donner la liste des css et js à lier
	private $css = [];
	private $js = [];

	function __construct()
	{
		$this->main[] = "Bienvenue sur la page Des amis!<br>";

		ob_start();
		include(VIEW.'elements/test.php');
		$this->main[] = ob_get_clean();

		//On rend directement la page avec la méthode "render"
		$this->render();
	}
}
