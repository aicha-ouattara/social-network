<?php

    class User extends Database{
        private $id=null;
        private $login=null;
        private $password=null;
        private $authtoken=null;
        private $mail=null;
        private $id_mail=null;
        private $id_settings=null;
        private $id_informations=null;
        private $followers=null;
        private $followings=null;
        private $picture=null;
        private $bio=null;
        private $city=null;
        private $country=null;
        private $lastname=null;
        private $firstname=null;
        private $birthdate=null;
        private $phone=null;

        /**
         * Available functions :
         *  getHis($attribute) : get any existing attribute from an user
         *  subscribe() : subscribe an user
         *  connect() : connect an user
         *  exists() : check if a mail or a login exists
         *  createToken() : generate an authtoken
         *  sendToken($token) : update authtoken 
         *  createSettings() : generate settings for an user 
         *  getSettings() : get every data from table `user_settings`
         *  getRealIp() : get the actual ip related to an user
         *  getRealPwd() : get the actual password related to an user
         *  getRealStatus : get the actual status of an user ( active / inactive )
         *  getProfile() : get every data from table `users` 
         *  getPublicProfile() : get every data needed to show to a visitor
         *  getFollowers() / getFollowings() : get an user's followers / followings
         *  getMessages() : get all messages sent and received
         *  isFollowing($id) : check if the user is following another user by hid $id
         *  follow($id) / unfollow(id) : make the user follow / unfollow another user by his $id
         *  setProfile($item, $path) : set new $path for specified $item
         *  setNewPassword($pwd) : update user's password
         *  updateHis(*) : update one user value
         *  updateInformations($informations[]) : update user's informations
         *  updateMail($mail) : verify if the new mail already exists and update it
         *  deleteAccount() : delete the user
         */
        
        public function __construct(array $data = NULL, &$return = NULL){
            parent::__construct();
            foreach($data as $key => $value){
                if($key=='login' || $key=='password' || $key=='mail' || $key=='authtoken' || $key=='id')
                    $this->$key = htmlspecialchars($value);
                elseif($key=='submit' || $key=='cpassword') null;
                else return $return='invalid_field';
            }
            if(filter_var($this->login, FILTER_VALIDATE_EMAIL) && $this->mail == NULL){
                $this->mail = $this->login; 
                $this->login = NULL;
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
            $stmt=self::$db->prepare(
                "UPDATE users u 
                INNER JOIN mails m 
                ON u.id_mail = m.id 
                SET u.authtoken=? 
                WHERE u.login = ? OR m.address = ?");
            $stmt->execute([$token, $this->login, $this->mail]);
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
                    $stmt = self::$db->prepare(
                        "BEGIN;
                        INSERT INTO mails (address) VALUES(?);
                        SELECT @mail_id := LAST_INSERT_ID();
                        INSERT INTO user_informations (registerdate) VALUES (DATE(NOW()));
                        SELECT @informations_id := LAST_INSERT_ID();
                        INSERT INTO users (id_mail, id_informations, login, password, active) VALUES(@mail_id, @informations_id, ?, ?, 0);
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
            $stmt = self::$db->prepare(
                'SELECT u.id as `id`, u.login as `login`, u.id_mail as `id_mail`, u.id_settings as `id_settings`,
                u.id_informations as `id_informations`, m.address as `mail`, 
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
            $this->id_informations!==NULL ? self::getInformations() : null;
            return $this;
        }

        public function getSettings(){
            $stmt = self::$db->prepare(
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

        public function getInformations(){
            $stmt = self::$db->prepare(
                'SELECT i.bio, i.country, i.city, i.lastname, i.firstname, i.birthdate, i.registerdate, i.phone 
                FROM user_informations i 
                INNER JOIN users u ON u.id_informations = i.id 
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

        public function getPublicProfile(&$return=NULL){
            $stmt = self::$db->prepare(
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

        public function getLoginById(){
            $stmt = self::$db->prepare(
                'SELECT `login` FROM `users` WHERE `id` = ?'
            );
            $stmt->execute([$this->id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $result !== false ? $this->login = $result['login'] : $this->login = 'Utilisateur supprimé';
        }

        public function getHis(string $item){
            return $this->$item;
        }

        public function getFollowers(int $id = NULL){
            $stmt = self::$db->prepare(
                "SELECT COUNT('id_following') as `followers` FROM `follows` 
                WHERE `id_followed`=?"
            );
            $id!== NULL ? $stmt->execute([$id]) : $stmt->execute([$this->id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->followers = $result['followers'];
        }

        public function getFollowersLogins(){
            $stmt = self::$db->prepare(
                'SELECT u.id, u.login 
                FROM users u
                INNER JOIN follows f 
                ON f.id_following = u.id 
                WHERE f.id_followed = ?'
            );
            $stmt->execute([$this->id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function getFollowings(int $id = NULL){
            $stmt = self::$db->prepare(
                "SELECT COUNT('id_followers') as `followings` FROM `follows` 
                WHERE `id_following`=?"
            );
            $id!== NULL ? $stmt->execute([$id]) : $stmt->execute([$this->id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->followings = $result['followings'];
        }

        public function getFollowingsLogins(){
            $stmt = self::$db->prepare(
                'SELECT u.id, u.login 
                FROM users u
                INNER JOIN follows f 
                ON f.id_followed = u.id 
                WHERE f.id_following = ?'
            );
            $stmt->execute([$this->id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function getConversations(int $range){
            self::$db->setAttribute( PDO::ATTR_EMULATE_PREPARES, false );
            $stmt = self::$db->prepare(
                'SELECT `id_sender`, `id_receiver`, `content`, `date`, `conversation`, `emoji`, `status` 
                FROM messages 
                WHERE id IN
                    (SELECT max(id) 
                    FROM messages 
                    WHERE :id IN (id_sender, id_receiver) 
                    GROUP BY `conversation`) 
                LIMIT :offset,10'
            );
            $stmt->execute([':id' => $this->id, ':offset' => $range]);
            self::$db->setAttribute( PDO::ATTR_EMULATE_PREPARES, true );
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function isFollowing(int $id_user2){
            $stmt = self::$db->prepare(
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
            $stmt = self::$db->prepare(
                'INSERT INTO follows (id_following, id_followed, date) 
                VALUES (?,?, DATE(NOW()) )');
            $stmt->execute([$this->id, $id_user2]);
        }

        public function unfollow(int $id_user2){
            $stmt = self::$db->prepare(
                'DELETE FROM follows 
                WHERE id_followed = ? AND id_following = ?');
            $stmt->execute([$id_user2, $this->id]);
        }

        public function setProfile(string $item, string $path){
            self::deletePrevious($item);
            $item = 's.' . $item;
            $stmt = self::$db->prepare(
                "UPDATE user_settings AS s 
                INNER JOIN users AS u ON u.id_settings = s.id 
                SET $item = ? 
                WHERE u.login = ?"
            );
            $stmt->execute([$path, $this->login]);
            $this->getSettings();
        }

        public function deleteImage(string $image){
            $stmt = self::$db->prepare(
                "UPDATE`user_settings` 
                SET $image = 0
                WHERE $image = ?"
            );
            $stmt->execute([$this->$image]);
            self::deletePrevious($image);
            $this->$image = 0;
        }

        protected function deletePrevious(string $item){
            is_file(ROOT . $this->$item) ? unlink(ROOT . $this->$item) : null;
        }

        public function setNewPassword(string $password){
            $stmt = self::$db->prepare(
                'UPDATE users SET `password` = ? WHERE `id` = ?'
            );
            $stmt->execute([password_hash($password, PASSWORD_DEFAULT), $this->id]);
        }

        public function updateInformations(array $data = NULL){
            foreach($data as $key=>$value){
                $this->$key = $value;
                self::updateHis($key, $value);
            }
        }

        protected function updateHis(string $key, $value){
            $column = 'i.' . $key;
            $stmt = self::$db->prepare(
                "UPDATE user_informations AS i 
                INNER JOIN users AS u ON u.id_informations = i.id 
                SET $column = ? 
                WHERE u.id = ?"
            );
            $stmt->execute([$value, $this->id]);
        }

        public function updateMail($new_mail){
            $prev_mail = $this->mail;
            $prev_login = $this->login;
            $this->mail = $new_mail;
            $this->login = null;
            if(self::exists()==false){
                $stmt = self::$db->prepare(
                    'UPDATE mails as m 
                    INNER JOIN users as u 
                    ON u.id_mail = m.id 
                    SET m.address = ? 
                    WHERE u.id = ?'
                );
                $stmt->execute([$this->mail, $this->id]);
                $this->login = $prev_login;
                return 1;
            }
            else{
                $this->login = $prev_login;
                $this->mail = $prev_mail;
                return 0;
            }
        }

        public function deleteAccount(){
            $stmt = self::$db->prepare(
                "DELETE FROM `mails` 
                WHERE `address` = ?;
                DELETE FROM `users` 
                WHERE `login` = ?;"
            );
            $stmt->execute([$this->mail, $this->login]);
        }
    }