<section>
<?php foreach($messages as $key => $message){?>
    <div id="message_<?=$message['id'];?>" class="<?=$message['id_receiver']==$user->getHis('id') ? 'received' : 'sent'?>">
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

<script>
    $(function(){
        $('.received').append('<div class="emoji_spawner"><button class="emoji_button emoji_1"><i class="far fa-grin-alt"></i></button></div>')

        $(document).on('click', 'button.emoji_button', function(){
            div_emoji = $(this).parent('.emoji_spawner')
            if(!div_emoji.hasClass('opened')){
                div_emoji.addClass('opened')
                div_emoji.append(
                    '<button class="emoji_button emoji_2"><i class="far fa-grin-squint"></i></button></div>\
                    <button class="emoji_button emoji_3"><i class="far fa-grin-hearts"></i></button></div>\
                    <button class="emoji_button emoji_4"><i class="far fa-grin-beam-sweat"></i></button></div>\
                    <button class="emoji_button emoji_5"><i class="far fa-sad-tear"></i></button></div>\
                    <button class="emoji_close"><i class="fas fa-times"></i></i></button></div>'
                )
            }
            else{
                sendEmoji($(this).attr('class'))
                closeEmoji(div_emoji)
            }
        })

        $(document).on('click', 'button.emoji_close', function(){ closeEmoji($(this).parent())})
    })

    function closeEmoji(div){
        div.removeClass('opened').find('.emoji_1').nextAll().remove()
    }

    function sendEmoji(emoji){
        emoji = emoji.split(' ')
        emoji = emoji[1].replace('emoji_', '')
        $.post('model/social/MessageHandler.php', {emoji, message:"<?=$message['id'];?>", conversation:"<?=$message['conversation'];?>"}, function(data){
            
        })
    }
</script>