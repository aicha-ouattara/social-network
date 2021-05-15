<section id="messages_box">
<?php foreach($conversations as $key => $conversation){
    if($conversation['id_userA']!=$user->getHis('id')){
        $user_chat = new User(['id' => $conversation['id_userA']]);
        $user_chat->getPublicProfile();
    }
    else{
        $user_chat = new User(['id' => $conversation['id_userB']]);
        $user_chat->getPublicProfile();
    }
    var_dump($user_chat);
    echo $user_chat->getHis('login'); ?>
    <div>
        <p></p>
    </div>
<?php } ?>
</section>