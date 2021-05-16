<section>
<?php foreach($messages as $key => $message){?>
    <div class="<?=$message['id_receiver']==$user->getHis('id') ? 'received' : 'sent'?>">
        <p style="display:flex;justify-content:space-between"><?=$message['sender'] . ' : ' . $message['content'];?></p>
    </div>
<?php } ?>
<form action="" id="messager">
    <input type="text" name="message" id="input_m" autocomplete="off">
    <button id="submit_m">Envoyer</button>
</form>
</section>

<style>
    .sent p{
        flex-direction : row-reverse;
    }
</style>