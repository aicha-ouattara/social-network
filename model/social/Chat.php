<?php

    class Chat extends User{
        protected $id_user = null;
        protected $conversation = null;

        public function __construct(int $conversation = null){
            Database::__construct();
            $this->conversation = $conversation;
        }

        public function getHis(string $item){
            return $this->$item;
        }

        public function exists(int $id_userA, int $id_userB){
            $stmt = self::$db->prepare(
                'SELECT `conversation` 
                FROM `messages` 
                WHERE ( `id_receiver` = :id_userA AND `id_sender` = :id_userB ) 
                OR (`id_receiver` = :id_userB AND `id_sender` = :id_userA )'
            );
            $stmt->execute([':id_userA' => $id_userA, ':id_userB' => $id_userB]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if($result){
                $this->conversation = $result['conversation'];
                return true;
            }
            else return false;
        }

        public function verifyAccess(int $id){
            $stmt = self::$db->prepare(
                'SELECT `id` FROM `messages` 
                WHERE ? IN (`id_sender`, `id_receiver`) AND `conversation` = ?'
            );
            $stmt->execute([$id, $this->conversation]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if($result === false) return 0;
            else{
                $this->id_user = $id;
                return 1;
            }
        }

        public function getMessages(int $limit){
            $stmt = self::$db->prepare(
                "SELECT COUNT(`conversation`) as `counter` 
                FROM `messages` 
                WHERE `conversation` = ?"
            );
            $stmt->execute([$this->conversation]);
            $total = $stmt->fetch(PDO::FETCH_ASSOC);

            $stmt = self::$db->prepare(
                "SELECT
                s.login sender, r.login receiver, 
                m.id, m.id_sender, m.id_receiver, m.date, m.content, m.conversation, m.emoji, m.status 
                FROM
                    messages m
                LEFT JOIN
                    users s ON
                    m.id_sender = s.id
                LEFT JOIN
                    users r ON
                    m.id_receiver = r.id
                WHERE m.conversation = ? 
                ORDER BY m.date DESC
                LIMIT $limit"
            );
            $stmt->execute([$this->conversation]);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $results = array_reverse($results);
            $results['total'] = $total['counter'];
            self::seen();
            return $results;
        }

        private function seen(){
            $stmt = self::$db->prepare(
                "UPDATE messages m 
                SET m.status = 'Vu' 
                WHERE m.conversation = ? AND m.id_receiver = ?"
            );
            $stmt->execute([$this->conversation, $this->id_user]);
        }

        public function newConversation(int $id_sender, int $id_receiver, string $message){
            $message = htmlspecialchars($message);
            $this->id_user = $id_sender;
            $stmt = self::$db->prepare(
                "INSERT INTO `messages` (`conversation`, `id_sender`, `id_receiver`, `content`, `date`, `emoji`, `status`) 
                SELECT MAX(`conversation`) + 1, ?, ?, ?, NOW(), 0, 'Envoyé' FROM `messages`"
            );
            $stmt->execute([$id_sender, $id_receiver, $message]);
            // self::getInsert();
        }

        private function getInsert(){
            $stmt = self::$db->prepare(
                "SELECT `conversation`
                FROM `messages` 
                WHERE `id_sender` = ? AND `id_receiver` = ?"
            );
            $stmt->execute([$this->id_sender, $this->id_receiver]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->conversation = $result['conversation'];
            return $this->conversation;
        }
    }
