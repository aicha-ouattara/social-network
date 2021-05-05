<?php
    if(!isset($db) || !$db){
        $db= new PDO('mysql:host=localhost;dbname=socialnetwork;charset=UTF8mb4', 'root', '');

        /* Creation de la db si besoin
        
        $link= new PDO('mysql:host=localhost;', 'root', '');
        $link->query('CREATE DATABASE IF NOT EXISTS `socialnetwork` CHARACTER SET utf8mb4');
        $query=("SELECT COUNT(DISTINCT `table_name`) as `tables` FROM `information_schema`.`columns` WHERE `table_schema` = 'socialnetwork'");
        $exist=$db->query($query);
        $exist=$exist->fetch(PDO::FETCH_ASSOC);
        if($exist['tables']<1){
            $sql= file_get_contents('socialnetwork.sql');
            $sql_cr= $db->exec($sql);
        } */
    }