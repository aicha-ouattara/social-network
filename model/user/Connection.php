<?php

    class Connection extends Connect{

        public function __construct($array, &$return){
            if(count($array)!==3) return $return='invalid_form';
            else{
                $this->login = htmlspecialchars($array['login']);
                $this->password = htmlspecialchars($array['password']);
                $this->ip = $_SERVER['REMOTE_ADDR'];
                $return = 'allgood';
            }
        }

        public function connect(){
            $user = (new DataFetcher())->getLoginInfos($this->login);
            if(password_verify($this->password, $user['password'])){
                if($this->ip==$user['ip']){
                    if($user['active']==1){
                        $authtoken = self::create_token();
                        $cookie_options = array(
                            'expires' => time() + 36000,
                            'path' => '/',
                            'domain' => 'localhost',
                            'secure' => true,
                            'httponly' => false,
                            'samesite' => 'Strict'
                        );
                        setcookie('authtoken', $authtoken, $cookie_options);
                        (new DataSender())->sendToken($authtoken, $user['id']);
                        return $return = 'connected';
                    }
                    else return $return = 'inactive';
                }
                else return $return = 'bad_ip';
            }
            else return $return = 'bad_login';
        }

        private function create_token(){
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
    }