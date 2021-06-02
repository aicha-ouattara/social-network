<!--
    $friends => array of every 'followback' users ['login' => 'online'] / online = 0 = disconnected, online = 1 = connected
-->
<section id="friends_list">
    <h3>Liste d'amis</h3>
    <?php foreach($friends as $key => $value){ ?>
        <p id="friend_<?=$key;?>">
            <a href="profil&user=<?=$key;?>"><?=$key;?></a> - 
            <span class="friend_status">
                <?= $value ? 'Connecté' : 'Déconnecté';?>
            </span>
        </p>
    <?php } ?>
</section>

<hr>

<section id="messages_box">
<!--
    $conversations = array of every conversation involving the user ['key' => 'conversation']
    $conversation = last message from a specific conversation
    $chat_pair = who the user is chatting with
-->
    <?php foreach($conversations as $key => $conversation){
        $chat_pair = $conversation['id_sender']==$user->getHis('id') ? new User(['id' => $conversation['id_receiver']]) : new User(['id' => $conversation['id_sender']]);
        $chat_pair->getLoginById();
        $day = date_format(new Datetime($conversation['date']), 'd-m-Y');
        $time = date_format(new Datetime($conversation['date']), 'H:i:s');
    ?>
    <a href="messages&conversation=<?=$conversation['conversation'];?>">
        <div style="display:flex;justify-content:space-around">
            <p><?=$chat_pair->getHis('login');?> </p>
            <p><?=$conversation['content'];?> </p>
            <p><?='Le ' . $day . ' à ' . $time;?></p>
        </div>
    </a>
    <?php } ?>
</section>