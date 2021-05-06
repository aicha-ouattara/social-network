<?php

    class DataFetcher extends Database{
        
        public function getDB(){
            return self::$db;
        }

        public function userExists(string $login, string $mail){
            $query = self::$db->prepare(
                'SELECT u.active FROM users u 
                INNER JOIN mails m ON u.id_mail=m.id 
                WHERE u.login=? OR m.address=?');
            $query->execute([$login, $mail]);
            $result=$query->fetch(PDO::FETCH_ASSOC);
            return $query->fetch(PDO::FETCH_ASSOC);
        }
    }