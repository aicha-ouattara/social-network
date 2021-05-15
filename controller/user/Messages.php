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
            if(!isset($_GET['message']) || $_GET['message']==NULL){
                $conversations = $user->getConversations(0);
                include VIEW . 'user/messages.php';
            }
            else{
                $conversation = new Chat($_GET['message']);
                if($conversation->verifyAccess($user->getHis('id'))){
                    $messages = $conversation->getMessages();
                    include VIEW . 'user/conversation.php';
                }
                else include VIEW . 'user/messages.php';
            }
        }

        $this->main[]=ob_get_clean();
        $this->render();
    }

}