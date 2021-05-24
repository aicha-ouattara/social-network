<?php
    require '../data/Database.php';
    require '../user/User.php';
    require 'Chat.php';

    class Message extends Chat{
        private $id = null;
        private $id_conversation = null;
        private $id_user = null;

        public function __construct(int $id_message, int $id_conversation, int $user){
            parent::__construct($id_conversation);
            $this->id = $id_message;
            $this->id_conversation = $id_conversation;
            $this->user = $user;
        }

        public function verifyReceiver(){
            $stmt = self::$db->prepare(
                'SELECT `id_receiver`
                FROM `messages` 
                WHERE `id` = ?'
            );
            $stmt->execute([$this->id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if($result['id_receiver'] == $this->user) return 1;
            else return 0;
        }

        public function verifySender(){
            $stmt = self::$db->prepare(
                'SELECT `id_sender`
                FROM `messages` 
                WHERE `id` = ?'
            );
            $stmt->execute([$this->id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if($result['id_sender'] == $this->user) return 1;
            else return 0;
        }

        public function updateEmoji(int $emoji){
            $stmt = self::$db->prepare(
                'UPDATE `messages`
                SET `emoji` = ? 
                WHERE `id` = ? AND `conversation` = ?'
            );
            $stmt->execute([$emoji, $this->id, $this->id_conversation]);
        }

        public function deleteSelf(){
            $stmt = self::$db->prepare(
                'DELETE FROM `messages` 
                WHERE `id` = ?'
            );
            $stmt->execute([$this->id]);
        }
    }

    if(isset($_POST['emoji']) && $_POST['emoji'] && isset($_POST['message']) && $_POST['message'] && isset($_POST['user']) && $_POST['user']){
        $id_message = intval(str_replace('message_', '', $_POST['message']));
        $message = new Message($id_message, $_POST['conversation'], $_POST['user']);
        if($message->verifyReceiver()) $message->updateEmoji($_POST['emoji']);
    }

    else if(isset($_POST['delete']) && $_POST['delete'] == 1 && isset($_POST['id']) && $_POST['id'] && isset($_POST['user']) && $_POST['user']){
        $message = new Message(intval($_POST['id']), intval($_POST['conversation']), intval($_POST['user']));
        if($message->verifySender()) $message->deleteSelf();
    }