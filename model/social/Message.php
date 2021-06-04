<?php
    require '../data/Database.php';
    require '../user/User.php';
    require 'Chat.php';

    class Message extends Chat{
        protected $id = null;
        protected $id_conversation = null;
        protected $id_user = null;
        protected $id_partner = null;
        protected $message = null;

        public function __construct(int $id_message = NULL, int $id_conversation = NULL, int $id_user = NULL, int $id_partner = NULL, string $message = NULL){
            parent::__construct($id_conversation);
            $this->id = $id_message;
            $this->id_conversation = $id_conversation;
            $this->id_user = $id_user;
            $this->id_partner = $id_partner;
            $this->message = $message;
        }

        public function verifyReceiver(){
            $stmt = self::$db->prepare(
                'SELECT `id_receiver`
                FROM `messages` 
                WHERE `id` = ?'
            );
            $stmt->execute([$this->id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if($result['id_receiver'] == $this->id_user) return 1;
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
            if($result['id_sender'] == $this->id_user) return 1;
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

        public function send(){
            $stmt = self::$db->prepare(
                "INSERT INTO `messages` (`conversation`, `id_sender`, `id_receiver`, `content`, `date`, `status`) 
                VALUES ( ? , ? , ? , ? , NOW(), 'Envoyé')"
            );
            // Fetch receiver
            $stmt->execute([$this->id_conversation, $this->id_user, $this->id_partner, $this->message]);
        }
    }

    if(isset($_POST['emoji']) && $_POST['emoji'] && isset($_POST['message']) && $_POST['message'] && isset($_POST['user']) && $_POST['user']){
        $id_message = intval(str_replace('message_', '', $_POST['message']));
        $message = new Message(intval($id_message), intval($_POST['conversation']), intval($_POST['user']));
        if($message->verifyReceiver()) $message->updateEmoji($_POST['emoji']);
    }

    else if(isset($_POST['delete']) && $_POST['delete'] == 1 && isset($_POST['id']) && $_POST['id'] && isset($_POST['user']) && $_POST['user']){
        $message = new Message(intval($_POST['id']), intval($_POST['conversation']), intval($_POST['user']));
        if($message->verifySender()) $message->deleteSelf();
    }

    else if(isset($_POST['message']) && $_POST['message'] && isset($_POST['user']) && $_POST['user'] && isset($_POST['partner']) && $_POST['partner']){
        $message = new Message(null, intval($_POST['conversation']), intval($_POST['user']), intval($_POST['partner']), $_POST['message']);
        $message->send();
        echo json_encode($_POST);
    }