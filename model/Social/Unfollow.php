<?php
    require '../data/Database.php';
    require '../user/User.php';

    if(isset($_POST) && $_POST){
        if(isset($_POST['unfollow']) && $_POST['unfollow'] == 1 && isset($_POST['user1']) && $_POST['user1'] && isset($_POST['user2']) && $_POST['user2']){
            $user1 = new User(['id' => $_POST['user1']]);
            $user1->unfollow($_POST['user2']);
            echo $user1->isFollowing($_POST['user2']);
        }
        else{
            echo 'Une erreur inattendue est survenue.';
         }
    }