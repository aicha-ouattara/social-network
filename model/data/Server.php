<?php
    require 'Database.php';

    class JSFetcher extends Database{
        public $authtoken = null;
        public $id = null;

        public function __construct(string $authtoken){
            parent::__construct();
            $this->authtoken = $authtoken;
            self::getPublicProfile();
        }

        protected function getPublicProfile(){
            $stmt = self::$db->prepare(
                'SELECT `id`, `login` 
                FROM `users` 
                WHERE `authtoken` = ? ',
            );
            $stmt->execute([$this->authtoken]);
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            foreach($results as $key => $value){
                $this->$key = $value;
            }
        }

        public function getHis(string $item){
            return $this->$item;
        }
    }

    if(isset($_POST['authtoken']) && $_POST['authtoken']){
        $user = new JSFetcher($_POST['authtoken']);
        echo json_encode($user);
    }