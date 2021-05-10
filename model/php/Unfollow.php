<?php
    require '../data/Database.php';
    require '../user/User.php';

    if(isset($_POST) && $_POST){
        if(isset($_POST['unfollow']) && $_POST['unfollow'] == 1 && isset($_POST['user1']) && $_POST['user1'] && isset($_POST['user2']) && $_POST['user2']){
            $user1 = new User(['id' => $_POST['user1']]);
            $user2 = new User(['id' => $_POST['user2']]);
            $user1->unfollow($user2->getHis('id'));
            echo json_encode(['return' => $user1->isFollowing($user2->getHis('id')), 'followers' => $user2->getFollowers()]);
        }
        else{
            echo "notsub";
        }
    }