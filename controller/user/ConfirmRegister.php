<?php

class Delete extends View{
    
    protected $pageTitle = "Activation du compte";

    public function __construct()
	{
        require VIEW . 'elements/session.php';

        ob_start();

        if(isset($_GET['u'], $_GET['a'], $_GET['t']) && $_GET['u'], $_GET['a'] == 1, $_GET['t']){
            $user = new User(['id' => intval($_GET['u'])]);

        }
        else{
            $error = ['origin' => 'confirm_register', 'message' => 'Vous ne pouvez pas accéder à cette page.'];
            include VIEW . 'error.php';
        }
        
        $this->main[] = ob_get_clean();
        $this->render();
    }
}