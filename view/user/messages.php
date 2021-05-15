<section id="messages_box">
<?php foreach($conversations as $key => $conversation){
    $chat_pair = $conversation['id_userA']==$user->getHis('id') ? new User(['id' => $conversation['id_userB']]) : new User(['id' => $conversation['id_userA']]);
    $chat_pair->getLoginById();
    $day = date_format(new Datetime($conversation['date']), 'd-m-Y');
    $time = date_format(new Datetime($conversation['date']), 'H:i:s');
?>
<a href="messages&message=<?=$conversation['conversation'];?>">
    <div style="display:flex;justify-content:space-around">
        <p><?=$chat_pair->getHis('login');?> </p>
        <p><?=$conversation['content'];?> </p>
        <p><?='Le ' . $day . ' à ' . $time;?></p>
    </div>
</a>
<?php } ?>
</section>