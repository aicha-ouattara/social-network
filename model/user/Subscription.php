<?php

    class Subscription extends Register{
        
        public function __construct($array, &$return){
            /**
             * Verify all inputs
             */
            if(count($array)!==5) return $return='invalid_form';
            else if($array['password']!==$array['cpassword']) return $return='invalid_match';
            else if(
                strlen($array['login'])<4 || strlen($array['login'])>30 ||
                !preg_match("/^[a-zA-Z0-9-_'âàéèêôîûÂÀÉÈÊ ]*$/",$array['login'])) return $return='invalid_login';
            else if(strlen($array['password'])<8 || !self::verifyPwd($array['password'])) return $return='invalid_password';
            else if(!filter_var($array['mail'], FILTER_VALIDATE_EMAIL) || !strpos($array['mail'], '@laplateforme.io')) return $return='invalid_mail';
            /**
             * If everything's in order
             */
            else foreach($array as $key => $value){
                if($key=='login' || $key=='password' || $key=='cpassword' || $key=='mail')
                    $this->$key = htmlspecialchars($value);
                elseif($key=='submit') null;
                else return $return='invalid_field';
            }
            return $return='allgood';
        }

        public function subscribe(){
            $db = new DataFetcher();
            if(!$db->userExists($this->login, $this->mail)){
                $array=['login' => $this->login, 'password' => $this->password, 'mail' => $this->mail];
                $user = new DataSender();
                try{
                    $user->subUser($array);
                    return $return='success';
                }catch(Exception $e){
                    return $return=$e;
                }
            }
        }

        public function verifyPwd(string $password){
            if( !preg_match('@[A-Z]@', $password) || !preg_match('@[a-z]@', $password) ||
                !preg_match('@[0-9]@', $password) || !preg_match('@[^\w]@', $password) ||
                strlen($password)<8 ){
                    return 0;
                }
            else{
                return 1;
            }
        }

    }