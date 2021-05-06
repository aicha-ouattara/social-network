<?php

    class DataSender extends Database{

        public function subUser(array $user){
            $ip = $_SERVER['REMOTE_ADDR'];
            $stmt = self::$db->prepare(
                "BEGIN;
                INSERT INTO mails (address)
                VALUES(?);
                INSERT INTO users (id_mail, login, password, active) 
                VALUES(LAST_INSERT_ID(), ?, ?, 0);
                INSERT INTO ips (id_client, address) 
                VALUES(LAST_INSERT_ID(), $ip);
                COMMIT;"
            );
            $stmt->execute([$user['mail'], $user['login'], password_hash($user['password'], PASSWORD_DEFAULT)]);
        }

        public function sendToken(string $token, string $id){
            $stmt=self::$db->prepare("UPDATE `users` SET `authkey`=? WHERE `id`=?");
            $stmt->execute([$token, $id]);
        }
    }