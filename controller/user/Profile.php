<?php

class Profile extends View{
    
    private $pageTitle = "Profil";

    private $css = [];
    private $js = [];

    public function __construct()
	{
        require VIEW . 'elements/session.php';

        /**
         * Replace all echos with specifics views
         */
        
        if(!isset($authorize) || $authorize!==1){
            echo "Vous devez vous connecter.";
        }

        else include './view/user/profile.php';
        $this->main[] = '';

        $this->render();
    }
}