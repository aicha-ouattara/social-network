<?php
    require '../data/Database.php';
    require '../user/User.php';
    require 'Chat.php';

    class MessageHandler extends Chat{
        private $id = null;
        private $id_conversation = null;

        public function __construct(int $id_message, int $id_conversation){
            parent::__construct($id_conversation);
            $this->id = $id_message;
            $this->id_conversation = $id_conversation;
        }

        public function updateEmoji(int $emoji){
            $stmt = self::$db->prepare(
                'UPDATE `messages`
                SET `emoji` = ? 
                WHERE `id` = ? AND `conversation` = ?'
            );
            $stmt->execute([$emoji, $this->id, $this->id_conversation]);
        }
    }

    if(isset($_POST['emoji']) && $_POST['emoji'] && isset($_POST['message']) && $_POST['message']){
        $message = new MessageHandler($_POST['message'], $_POST['conversation']);
        $message->updateEmoji($_POST['emoji']);
    }