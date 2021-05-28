<?php

/**
 *
 */
class Test extends View
{
	// Il faut donner le titre de la page
	public $pageTitle = "WIP";

	// Il faut donner la liste des css et js à lier
	private $css = [];
	private $js = [];

	function __construct()
	{

		// Données pour le formulaire d'ajout d'un post
		$model = new Request();
		$categories = $model->selectAll('categories');

		ob_start();
		include(VIEW.'forms/postForm.php');
		$this->main[] = ob_get_clean();

		ob_start();
		include(VIEW.'forms/likeForm.php');
		$this->main[] = ob_get_clean();

		ob_start();
		include(VIEW.'forms/commentForm.php');
		$this->main[] = ob_get_clean();

		ob_start();
		include(VIEW.'forms/postReactionForm.php');
		$this->main[] = ob_get_clean();

		//On rend directement la page avec la méthode "render"
		$this->render();
	}
}
