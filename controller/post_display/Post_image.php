<?php


/**
 *
 */
class Post_image extends View
{
    // Il faut donner le titre de la page
    protected $pageTitle = "post_image";

    // Il faut donner la liste des css et js à lier
    private $css = [];
    private $js = [];

    function __construct()
    {
        // Il faut remplir la variable $main des différents contenus du main (d'où la liste)
        // Cela va nous permettre de travailler par petits modules qu'on pourrait répéter ailleurs

        ob_start();
        include(VIEW . 'post_display/post_image.php');
        $this->main[] = ob_get_clean();

        //On rend directement la page avec la méthode "render"
        $this->render();
    }

}
