<?php

    class Database{

        protected static $db;

        public function __construct(){
            self::$db = new PDO('mysql:host=localhost;dbname=socialnetwork;charset=UTF8mb4', 'root', '');
        }
       
    }