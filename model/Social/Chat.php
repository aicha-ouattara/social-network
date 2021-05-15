<?php

    class Chat extends User{

        public function __construct(int $conversation){
            Database::__construct();
            $this->conversation = $conversation;
        }

        public function verifyAccess(int $id){
            $stmt = self::$db->prepare(
                'SELECT `id` FROM `messages` 
                WHERE ? IN (`id_sender`, `id_receiver`) AND `conversation` = ?'
            );
            $stmt->execute([$id, $this->conversation]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if($result === false) return 0;
            else return 1;
        }

        public function getMessages(){
            $stmt = self::$db->prepare(
                'SELECT
                s.login sender, r.login receiver, 
                m.id_sender, m.id_receiver, m.date, m.content, m.conversation, m.emoji, m.status 
            FROM
                messages m
            JOIN
                users s ON
                m.id_sender = s.id
            JOIN
                users r ON
                m.id_receiver = r.id
            WHERE m.conversation = ?'
            );
            $stmt->execute([$this->conversation]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
