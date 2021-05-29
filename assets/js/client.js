$(function(){
    if(document.cookie.indexOf('authtoken') > -1 ){
        socket = io.connect('http://localhost:443')
        socket.emit('authtoken', Cookies.get('authtoken'))
    }
    else{
        delete(socket)
    }
    /**
     * Messages handling
     */
    $('#messager').on('submit', function(e){
        e.preventDefault()
        const message = $('#input_m').val()
        // Si le message n'est pas vide
        if(message.length){
            $.post(
                'model/social/Message.php', 
                {user, partner, message, conversation}, 
                function(data){
                    $('#section_messages').load(location.href + ' #section_messages')
            })
            $('#input_m').val('').focus()
            socket.emit('message', message)
        }
        // Else
        else{}
    })

    socket.on('newmsg', function(message){
        $('#section_messages').load(location.href + ' #section_messages')
    })
})