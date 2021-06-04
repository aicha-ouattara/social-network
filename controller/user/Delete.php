<?php

class Delete extends View{
    
    protected $pageTitle = "Suppression de compte";

    private $css = [];
    private $js = [];

    public function __construct()
	{
        require VIEW . 'elements/session.php';

        ob_start();
        if(isset($_POST) && $_POST && isset($user) && $user){
            if(isset($_POST['delete_account']) && $_POST['delete_account']==1){
                include VIEW . 'user/delete.php';
            }
            else if(isset($_POST['confirm_delete']) && $_POST['confirm_delete']==1){
                $mail_address = $user->getHis('mail');
                $message = 'delaccount';
                $user->deleteAccount();
                include ROOT . 'mailer/mailer.php';
                $delete_return = 'Votre compte a bien été supprimé. Vous allez recevoir un mail de confirmation.';
                include VIEW . 'user/delete.php';
            }
        }
        else{
            $error = array('origin' => 'delete', 'message' => 'Vous devez vous connecter pour accéder à cette page.');
            include VIEW . 'error.php';
        }
        $this->main[] = ob_get_clean();
        $this->render();
    }
}