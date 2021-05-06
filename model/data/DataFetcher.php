<?php

    class DataFetcher extends Database{
        
        public function getDB(){
            return self::$db;
        }

        public function userExists(string $login, string $mail){
            $stmt = self::$db->prepare(
                'SELECT u.active FROM users u 
                INNER JOIN mails m ON u.id_mail=m.id 
                WHERE u.login=? OR m.address=?');
            $stmt->execute([$login, $mail]);
            $result=$stmt->fetch(PDO::FETCH_ASSOC);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function getLoginInfos(string $login){
            $stmt = self::$db->prepare(
                'SELECT u.id, u.password, u.active, i.address AS `ip` FROM users u 
                INNER JOIN mails m ON u.id_mail=m.id 
                INNER JOIN ips i ON i.id_client=u.id 
                WHERE u.login=? OR m.address=?');
            $stmt->execute([$login, $login]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        // public function getAllDatas(string $authtoken){

        // }
    }