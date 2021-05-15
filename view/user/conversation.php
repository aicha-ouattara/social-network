<section>
<?php foreach($messages as $key => $message){?>
    <div class="<?=$message['id_receiver']==$user->getHis('id') ? 'received' : 'sent'?>">
        <p style="display:flex;justify-content:space-between"><?=$message['sender'] . ' : ' . $message['content'];?> <small><?=$message['date'];?></small></p>
    </div>
<?php } ?>
</section>