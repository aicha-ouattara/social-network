<?php

    class User extends Database{
        private $id=null;
        private $login=null;
        private $password=null;
        private $authtoken=null;
        private $mail=null;
        private $id_mail=null;
        private $id_settings=null;
        private $id_preferences=null;
        private $id_userinfos=null;
        
        public function __construct(array $data = NULL, &$return = NULL){
            parent::__construct();
            foreach($data as $key => $value){
                if($key=='login' || $key=='password' || $key=='mail' || $key=='authtoken' || $key=='id')
                    $this->$key = htmlspecialchars($value);
                elseif($key=='submit' || $key=='cpassword') null;
                else return $return='invalid_field';
            }
            return $return='allgood';
        }

        private function exists(){
            $stmt = self::$db->prepare(
                'SELECT u.active FROM users u 
                INNER JOIN mails m ON u.id_mail=m.id 
                WHERE u.login=? OR m.address=?');
            $stmt -> execute([$this->login, $this->mail]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        }

        private function sendToken($token){
            $stmt=self::$db->prepare("UPDATE `users` SET `authtoken`=? WHERE `login`=?");
            $stmt->execute([$token, $this->login]);
        }

        private function createToken(){
            $date = (new DateTime())->getTimeStamp();
            $ip=$_SERVER['REMOTE_ADDR'];
            $start=random_int(1000,9999);
            $end=random_int(1000,9999);
            $token=$start . "-" . $date . ":" . $ip . "+" . $end;
            $iterations = random_int(30000,90000);
            $salt = openssl_random_pseudo_bytes(16);
            $hash = hash_pbkdf2("sha256", $token, $salt, $iterations, 32);
            return $hash;
        }

        private function getRealIP(){
            $stmt = self::$db->prepare(
                'SELECT i.address as `ip` FROM ips i 
                INNER JOIN users u ON i.id_user=u.id 
                INNER JOIN mails m on u.id_mail=m.id 
                WHERE u.login=? OR m.address=?'
            );
            $stmt -> execute([$this->login, $this->mail]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['ip'];
        }

        private function getRealPwd(){
            $stmt = self::$db->prepare(
                'SELECT u.password FROM users u 
                INNER JOIN mails m on u.id_mail=m.id 
                WHERE u.login=? OR m.address=?'
            );
            $stmt -> execute([$this->login, $this->mail]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['password'];
        }

        private function getRealStatus(){
            $stmt = self::$db->prepare(
                'SELECT u.active FROM users u 
                INNER JOIN mails m on u.id_mail=m.id 
                WHERE u.login=? OR m.address=?'
            );
            $stmt -> execute([$this->login, $this->mail]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['active'];
        }

        public function subscribe(){
            if(self::exists()==false){
                $ip = $_SERVER['REMOTE_ADDR'];
                try{
                    $stmt = parent::$db->prepare(
                        "BEGIN;
                        INSERT INTO mails (address) VALUES(?);
                        SELECT @last_id := LAST_INSERT_ID();
                        INSERT INTO users (id_mail, login, password, active) VALUES(@last_id, ?, ?, 0);
                        INSERT INTO ips (id_user, address) VALUES(@last_id, ?);
                        INSERT INTO inventory (id_user) VALUES(@last_id); 
                        INSERT INTO wallets(id_user, tokens) VALUES(@last_id, 500); 
                        COMMIT;"
                    );
                    $stmt->execute([$this->mail, $this->login, password_hash($this->password, PASSWORD_DEFAULT), $ip]);
                    return 'success';
                }
                catch(Exception $e){
                    echo $e->getMessage();
                    return 'error';
                }
            }
            else return 'user_exists';
        }
        
        public function connect(){
            if(self::exists()==false || !password_verify($this->password, self::getRealPwd())) return 'bad_login';
            else{
                if($_SERVER['REMOTE_ADDR']==self::getRealIP()){
                    if(self::getRealStatus()==1){
                        $authtoken = self::createToken();
                        $cookie_options = array(
                            'expires' => time() + 36000,
                            'path' => '/',
                            'domain' => 'localhost',
                            'secure' => true,
                            'httponly' => false,
                            'samesite' => 'Strict'
                        );
                        setcookie('authtoken', $authtoken, $cookie_options);
                        self::sendToken($authtoken);
                        return $return = 'connected';
                    }
                    else return 'inactive';
                }
                else return 'bad_ip';
            }
        }

        public function getProfile(){
            $stmt = parent::$db->prepare(
                'SELECT u.id as `id`, u.login as `login`, u.id_mail as `id_mail`, m.address as `mail`, 
                u.id_userinfos as `id_userinfos`, u.id_preferences as `id_preferences`, u.id_settings as `id_settings` 
                FROM users u INNER JOIN mails m ON u.id_mail=m.id 
                WHERE u.authtoken=?'
            );
            $stmt->execute([$this->authtoken]);
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            foreach($results as $key=>$value){
                $this->$key = $value;
            }
            return $this;
        }

    }