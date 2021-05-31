<?php

class Messages extends View{
    
    protected $pageTitle = 'Messages';
    private $css = [];
    private $js = [];

    public function __construct()
	{
        require VIEW . 'elements/session.php';
        ob_start();

        if(!isset($authorize) || $authorize!==1){
            $error = ['origin' => 'messages', 'message' => "Vous devez vous connecter pour accéder à cette page."];
            include VIEW . 'error.php';
        }
        else{
            if(!isset($_GET['conversation']) || $_GET['conversation']==NULL){
                $conversations = $user->getConversations(0);
                $_SESSION['messages_limit'] = 10;
                include VIEW . 'user/messages.php';
            }
            else{
                $conversation = new Chat($_GET['conversation']);
                if($conversation->verifyAccess($user->getHis('id'))){
                    $_SESSION['messages_limit'] = !isset($_SESSION['messages_limit']) || $_SESSION['messages_limit'] < 10 ? 10 : $_SESSION['messages_limit'];
                    $messages = $conversation->getMessages($_SESSION['messages_limit']);
                    include VIEW . 'user/conversation.php';
                    $this->jsList[] = 'conversation.js';
                }
                else header('Location:' . URL);
            }
        }

        $this->main[]=ob_get_clean();
        $this->render();
    }

}