<?php

class Settings extends View{
    
    protected $pageTitle = 'Paramètres';
    private $css = [];
    private $js = [];

    public function __construct()
	{
        require VIEW . 'elements/session.php';

        /**
         * Replace all echos with specifics views
         */

         if(isset($user) && $user){
            if(intval($user->getHis('id_settings')) == 0){
                $user->createSettings();
                $user->getSettings();
            }
            ob_start();
            include VIEW . 'user/settings.php';
            $this->main[] = ob_get_clean();
         }
         else $this->main[] = "Vous devez vous connecter.";

         $this->render();
    }
}