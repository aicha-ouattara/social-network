<section>
<?php foreach($messages as $key => $message){?>
    <div class="<?=$message['id_receiver']==$user->getHis('id') ? 'received' : 'sent'?>">
        <p style="display:flex;">
            <?= $message['sender']==null ? 'Utilisateur supprimé' : 
            '<a href="profil&user=' . $message['sender'] . '">' . $message['sender'] . '</a>'; 
            echo ' : ' . $message['content'];?></p>
    </div>
<?php } ?>
<form action="" id="messager">
    <input type="text" name="message" id="input_m" autocomplete="off">
    <button id="submit_m">Envoyer</button>
</form>
<a href="messages">Retour aux messages</a>
</section>

<style>
    .sent p{
        justify-content: flex-end;
    }
</style>