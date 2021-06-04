<?php
    // Define emojis
    $emoji_0 = null;
    $emoji_1 = '<i class="far fa-grin-alt"></i>';
    $emoji_2 = '<i class="far fa-grin-squint"></i>';
    $emoji_3 = '<i class="far fa-grin-hearts"></i>';
    $emoji_4 = '<i class="far fa-grin-beam-sweat"></i>';
    $emoji_5 = '<i class="far fa-sad-tear"></i>';
?>

<section id="section_messages">
    <h4 id="friend_conversation"><?=$partner->getHis('login');?> - <span class="friend_status"><?= $partner->getHis('online') ? 'Connecté' : 'Déconnecté';?></span></h4>
    <?php if($messages['total'] > $_SESSION['messages_limit']){?>
        <button id="more_messages">Afficher les messages plus anciens</button>
    <?php } 
    foreach($messages as $key => $message){
        if($key !== 'total'){ 
            $who = $message['id_receiver'] == $user->getHis('id') ? 'receiver' : 'sender'; ?>
            <div id="message_<?=$message['id'];?>" class="message_div <?= $who == 'receiver' ? 'received' : 'sent'?>">
                <p>
                    <?= $message['sender']==null ? 'Utilisateur supprimé' : 
                    '<a href="profil&user=' . $message['sender'] . '">' . $message['sender'] . '</a>'; 
                    echo ' : ' . $message['content'];?>
                    <br>
                    <?= !is_array(next($messages)) && $key !=='total' ? $message['status'] : null;?></p>
                    <div class="emoji_div" id='emoji_div_<?=$message['id'];?>'><?=${'emoji_' . $message['emoji']};?></div>
                    <?php if($who == 'sender'){ ?><button class="delete_message" id="delete_message_<?=$message['id'];?>">Supprimer</button> <?php } ?>
            </div>
        <?php }
    } ?>
    <form action="" id="messager">
        <input type="text" name="message" id="input_m" autocomplete="off">
        <button id="submit_m">Envoyer</button>
    </form>
    <a href="messages">Retour aux messages</a>  
</section>

<style>
    .sent{
        text-align:end;
    }
</style>

<script>
    conversation = "<?=$messages[0]['conversation'];?>"
    user = "<?=$user->getHis('id');?>"
    partner = "<?=$id_partner;?>"
</script>