<?php

class Messages extends View{
    
    protected $pageTitle = 'Messages';
    private $css = [];
    private $js = [];

    public function __construct()
	{
        require VIEW . 'elements/session.php';
        ob_start();
        // If the user isn't logged
        if(!isset($authorize) || $authorize!==1){
            $error = ['origin' => 'messages', 'message' => "Vous devez vous connecter pour accéder à cette page."];
            include VIEW . 'error.php';
        }
        // If the user is sending a message via the friends list
        else if(isset($_POST['sendto']) && $_POST['sendto']){
            // If the receiver is an actual friend
            if(array_key_exists($_POST['sendto'], $user->getFriends())){
                $conversation = new Chat();
                $partner = new User(['login' => $_POST['sendto']]);
                $partner->getIdByLogin();
                $partner->isOnline();
                // If the conversation already exists, load the conversation
                if($conversation->exists($user->getHis('id'), $partner->getHis('id'))){
                    $location = 'messages&conversation=' . $conversation->getHis('conversation');
                    header("Location: $location");
                    exit;
                }
                // Else create a new conversation
                else{
                    include VIEW . 'user/new_conversation.php';
                    $this->jsList[] = 'new_conversation.js';
                }
            }
            // If the user has no access to the receiver
            else{
                $error = ['origin' => 'messages', 'message' => "Vous ne pouvez pas communiquer avec cet utilisateur."];
                include VIEW . 'error.php';
            }
        }
        // If the user is sending a message for a new conversation
        else if(isset($_POST['new_conversation']) && $_POST['new_conversation'] == 1 && isset($_POST['message']) && $_POST['message']){
            var_dump($_POST);
        }
        else{
            // If the user isn't asking for a specific conversation, load all conversations
            if(!isset($_GET['conversation']) || $_GET['conversation']==NULL){
                $conversations = $user->getConversations(0);
                $friends = $user->getFriends();
                $_SESSION['messages_limit'] = 10;
                include VIEW . 'user/conversations.php';
            }
            // Else if the user is accessing a specific conversation, load its messages
            else{
                $conversation = new Chat($_GET['conversation']);
                // If the user actually has access to this conversation
                if($conversation->verifyAccess($user->getHis('id'))){
                    // Define messages limit ( 10 by 10 )
                    $_SESSION['messages_limit'] = !isset($_SESSION['messages_limit']) || $_SESSION['messages_limit'] < 10 ? 10 : $_SESSION['messages_limit'];
                    $messages = $conversation->getMessages($_SESSION['messages_limit']);
                    // Define partner
                    $id_partner = $user->getHis('id') == $messages[0]['id_receiver'] ? $messages[0]['id_sender'] : $messages[0]['id_receiver'];
                    $partner = new User(['id' => $id_partner]);
                    $partner->getLoginById();
                    $partner->isOnline();

                    include VIEW . 'user/messages.php';
                    $this->jsList[] = 'conversation.js';
                }
                // Else redirect to index
                else header('Location:' . URL);
            }
        }

        $this->main[]=ob_get_clean();
        $this->render();
    }
}