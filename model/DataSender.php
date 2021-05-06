<?php

    class DataSender extends Database{

        public function subUser(array $user){
            $query = self::$db->prepare(
                'BEGIN;
                INSERT INTO mails (address)
                VALUES(?);
                INSERT INTO users (id_mail, login, password, active) 
                VALUES(LAST_INSERT_ID(), ?, ?, 0);
                COMMIT;'
            );
            $query->execute([$user['mail'], $user['login'], password_hash($user['password'], PASSWORD_DEFAULT)]);
        }
    }