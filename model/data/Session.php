<?php

    class Session extends Database{

        public function __construct($authtoken = NULL){
            self::$db = (new DataFetcher())->getDB();
            $this->authtoken = $authtoken;
            $this->ip = $_SERVER['REMOTE_ADDR'];
        }
        
        public function authenticate(){
            $stmt = self::$db->prepare(
                'SELECT i.address AS `ip` FROM ips i
                INNER JOIN users u ON i.id_client=u.id 
                WHERE u.authkey = ?'
            );
            $stmt->execute([$this->authtoken]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if(isset($result['ip']) && $this->ip == $result['ip']) return 'validtoken';
            else return 'invalidtoken';
        }
    }