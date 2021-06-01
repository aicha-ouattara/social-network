<?php

/**
 *
 */
class AddPostDisplay extends View
{
    // Il faut donner le titre de la page
    protected $pageTitle = "addPostDisplay";

    // Il faut donner la liste des css et js à lier
    //private $css = [];
    //private $js = [];

    function __construct()
    {

        // Il faut remplir la variable $main des différents contenus du main (d'où la liste)
        // Cela va nous permettre de travailler par petits modules qu'on pourrait répéter ailleurs

        // Données pour le formulaire d'ajout d'un post
        $model = new Request();
        $categories = $model->selectAll('categories');

        ob_start();
        include(VIEW . 'forms/addPostForm.php');
        $this->main[] = ob_get_clean();


        //On rend directement la page avec la méthode "render"
        $this->render();
    }

}