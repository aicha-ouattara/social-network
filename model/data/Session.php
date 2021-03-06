<?php

    class Session extends Database{

        public function __construct($authtoken = NULL){
            parent::__construct();
            $this->authtoken = $authtoken;
            $this->ip = $_SERVER['REMOTE_ADDR'];
        }
        
        public function authenticate(){
            $stmt = self::$db->prepare(
                'SELECT i.address AS `ip` FROM ips i
                INNER JOIN users u ON i.id_user=u.id 
                WHERE u.authtoken = ?'
            );
            $stmt->execute([$this->authtoken]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if(isset($result['ip']) && $this->ip == $result['ip']) return 'validtoken';
            else return 'invalidtoken';
        }
    }