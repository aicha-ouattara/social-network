<?php

    class User extends Database{
        
        public function __construct(array $data){
            $i = 0;
            foreach($data as $key=>$value){
                $i == 0 ? $i = $key : null;
                $this->$key = $value;
            }
            self::expandData($i);
        }

        private function expandData(){
            // $stmt = self::$db->prepare(
            //     'SELECT u.id, u.login, u.id_mail, u.id_userinfos, u.id_preferences, u.id_settings, w.id, i.id '
            // )
        }
    }