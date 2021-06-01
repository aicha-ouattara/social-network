<?php

/**
 *
 */
class Test extends View
{
	// Il faut donner le titre de la page
	public $pageTitle = "Ajouter Post";

	// Il faut donner la liste des css et js à lier
	private $css = [];
	private $js = [];

	function __construct()
	{
		$this->main[] = "";

		// Données pour le formulaire d'ajout d'un post
		$model = new Request();
		$categories = $model->selectAll('categories');

		ob_start();
		include(VIEW.'forms/addLikeForm.php');
		$this->main[] = ob_get_clean();

		// $model = new Like();
		// var_dump($model->getAllUserLikes(2));

		ob_start();
		include(VIEW.'forms/addCommentForm.php');
		$this->main[] = ob_get_clean();

        ob_start();
        include(VIEW.'forms/addPostForm.php');
        $this->main[] = ob_get_clean();


        //On rend directement la page avec la méthode "render"
		$this->render();
	}
}
