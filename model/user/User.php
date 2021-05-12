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
        private $followers=null;
        private $followings=null;

        /**
         * Available functions :
         *  getHis(attribute) : get any existing attribute from an user
         *  subscribe() : subscribe an user
         *  connect() : connect an user
         *  exists() : check if a mail or a login exists
         *  createToken() : generate an authtoken
         *  sendToken(token) : update authtoken 
         *  createSettings() : generate settings for an user 
         *  getSettings() : get every data from table `user_settings`
         *  getRealIp() : get the actual ip related to an user
         *  getRealPwd() : get the actual password related to an user
         *  getRealStatus : get the actual status of an user ( active / inactive )
         *  getProfile() : get every data from table `users` 
         *  getPublicProfile() : get every data needed to show to a visitor
         *  getFollowers() / getFollowings() : get an user's followers / followings
         *  isFollowing(id) : check if the user is following another user by hid id
         *  follow(id) / unfollow(id) : make the user follow / unfollow another user by his id
         */
        
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

        private function sendToken($token){
            $stmt=self::$db->prepare("UPDATE `users` SET `authtoken`=? WHERE `login`=?");
            $stmt->execute([$token, $this->login]);
        }

        public function createSettings(){
            $stmt = self::$db->prepare(
                "BEGIN;
                INSERT INTO user_settings (picture, background) VALUES (0,0);
                UPDATE users SET id_settings = LAST_INSERT_ID() WHERE login = ?;
                COMMIT;"
            );
            $stmt->execute([$this->login]);
            $stmt->closeCursor();
            $this->getProfile();
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
                        SELECT @mail_id := LAST_INSERT_ID();
                        INSERT INTO users (id_mail, login, password, active) VALUES(@mail_id, ?, ?, 0);
                        SELECT @user_id := LAST_INSERT_ID();
                        INSERT INTO ips (id_user, address) VALUES(@user_id, ?);
                        INSERT INTO inventory (id_user) VALUES(@user_id); 
                        INSERT INTO wallets(id_user, tokens) VALUES(@user_id, 500);
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
                'SELECT u.id as `id`, u.login as `login`, u.id_mail as `id_mail`, u.id_settings as `id_settings`,
                u.id_userinfos as `id_userinfos`, u.id_preferences as `id_preferences`, m.address as `mail`, 
                w.id as `id_wallet`, w.tokens as `tokens`
                FROM users u 
                INNER JOIN mails m ON u.id_mail=m.id 
                INNER JOIN wallets w ON u.id=w.id_user 
                WHERE u.authtoken=?'
            );
            $stmt->execute([$this->authtoken]);
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            foreach($results as $key=>$value){
                $this->$key = $value;
            }
            self::getFollowers();
            self::getFollowings();
            $this->id_settings!==NULL ? self::getSettings() : null;
            return $this;
        }

        public function getSettings(){
            $stmt = parent::$db->prepare(
                'SELECT s.picture, s.background FROM user_settings s 
                INNER JOIN users u ON u.id_settings = s.id 
                WHERE u.id = ?'
            );
            $stmt->execute([$this->id]);
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            foreach($results as $key=>$value){
                $this->$key = $value;
            }
            $stmt->closeCursor();
            return $this;
        }

        public function getPublicProfile(&$return){
            $stmt = parent::$db->prepare(
                'SELECT u.id as `id`
                FROM users u 
                WHERE u.login=?'
            );
            $stmt->execute([$this->login]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if(empty($result)) return $return = 'no_user';
            else{ 
                $this->id = $result['id'];
                self::getFollowers();
                self::getFollowings();
                $return = 'user_found';
                return $this;
            }
        }

        public function getHis(string $item){
            return $this->$item;
        }

        public function getFollowers(int $id = NULL){
            $stmt = parent::$db->prepare(
                "SELECT COUNT('id_following') as `followers` FROM `follows` 
                WHERE `id_followed`=?"
            );
            $id!== NULL ? $stmt->execute([$id]) : $stmt->execute([$this->id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->followers = $result['followers'];
        }

        public function getFollowings(int $id = NULL){
            $stmt = parent::$db->prepare(
                "SELECT COUNT('id_followers') as `followings` FROM `follows` 
                WHERE `id_following`=?"
            );
            $id!== NULL ? $stmt->execute([$id]) : $stmt->execute([$this->id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->followings = $result['followings'];
        }

        public function isFollowing(int $id_user2){
            $stmt = parent::$db->prepare(
                'SELECT f.id FROM follows f 
                INNER JOIN users u ON u.id=f.id_following 
                WHERE f.id_following = ? AND f.id_followed = ?'
            );
            $stmt->execute([$this->id, $id_user2]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if(empty($result)){
                return 0;
            }
            else return 1;
        }

        public function follow(int $id_user2){
            $stmt = parent::$db->prepare(
                'INSERT INTO follows (id_following, id_followed, date) 
                VALUES (?,?, DATE(NOW()) )');
            $stmt->execute([$this->id, $id_user2]);
        }

        public function unfollow(int $id_user2){
            $stmt = parent::$db->prepare(
                'DELETE FROM follows 
                WHERE id_followed = ? AND id_following = ?');
            $stmt->execute([$id_user2, $this->id]);
        }

        public function setProfilePicture(string $path){
            $stmt = parent::$db->prepare(
                'UPDATE user_settings AS s 
                INNER JOIN users AS u ON u.id_settings = s.id 
                SET s.picture = ? 
                WHERE u.login = ?'
            );
            $stmt->execute([$path, $this->login]);
        }

    }