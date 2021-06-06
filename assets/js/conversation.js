$(function(){
    // Append emoji to concerned divs
    appendEmojisMenu()
    // Emojis menu
    $(document).on('click', 'button.emoji_button', function(){
        div_emoji = $(this).parent('.emoji_spawner')
        // Show emojis menu
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
        // Send emoji in db
        else{
            sendEmoji($(this).parents('.message_div').attr('id'), $(this).attr('class'), $(this).parents('.message_div').children('.emoji_div').attr('id'))
            closeEmoji(div_emoji)
        }
    })
    // Close emojis menus
    $(document).on('click', 'button.emoji_close', function(){ closeEmoji($(this).parent())})
    // Delete a message
    $(document).on('click', '.delete_message', function(){
        deleteMessage($(this).parents('.message_div').attr('id'))
    })
    // Show more messages
    $(document).on('click', '#more_messages', function(){
        $.post('model/social/MessageSession.php', {more:1}, function(data){
            $('#section_messages').load(' #section_messages > *', appendEmojisMenu)
        })
    })
})

function appendEmojisMenu(){
    $("#section_messages").children('.received').append('<div class="emoji_spawner"><button class="emoji_button emoji_1"><i class="far fa-grin-alt"></i></button></div>')
}

function closeEmoji(div){
    div.removeClass('opened').find('.emoji_1').nextAll().remove()
}

function sendEmoji(message, emoji, div){
    emoji = emoji.split(' ')
    emoji = emoji[1].replace('emoji_', '')
    $.post(
        'model/social/Message.php', 
        {emoji, message, user, conversation}, 
        function(data){
            $("#" + div).load(location.href + " #" + div)
    })
    let data = {partner, message}
    socket.emit('emoji', data)
}

function deleteMessage(id){
    id = id.replace('message_', '')
    $.post(
        'model/social/Message.php', 
        {delete:1, id, user, conversation}, 
        function(data){
            $('#section_messages').load(' #section_messages > *', appendEmojisMenu)
        }
    )
}