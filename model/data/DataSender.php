<?php

    class DataSender extends Database{

        public function subUser(array $user){
            $ip = $_SERVER['REMOTE_ADDR'];
            $stmt = self::$db->prepare(
                "BEGIN;
                INSERT INTO mails (address) VALUES(?);
                SELECT @last_id := LAST_INSERT_ID();
                INSERT INTO users (id_mail, login, password, active) VALUES(@last_id, ?, ?, 0);
                INSERT INTO ips (id_user, address) VALUES(@last_id, ?);
                INSERT INTO inventory (id_user) VALUES(@last_id); 
                INSERT INTO wallets(id_user, tokens) VALUES(@last_id, 500); 
                COMMIT;"
            );
            $stmt->execute([$user['mail'], $user['login'], password_hash($user['password'], PASSWORD_DEFAULT), $ip]);
        }

        public function sendToken(string $token, string $id){
            $stmt=self::$db->prepare("UPDATE `users` SET `authkey`=? WHERE `id`=?");
            $stmt->execute([$token, $id]);
        }
    }