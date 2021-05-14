<?php

class Messages extends View{
    
    protected $pageTitle = 'Messages';
    private $css = [];
    private $js = [];

    public function __construct()
	{
        require VIEW . 'elements/session.php';
        /**
         * Replace all echos with specifics views
         */

        ob_start();

        if(!isset($authorize) || $authorize!==1){
            echo "Vous devez vous connecter pour accéder à cette page.";
        }
        else{
            $user->getMessages();
            
        }

        $this->main[]=ob_get_clean();
        $this->render();
    }

}