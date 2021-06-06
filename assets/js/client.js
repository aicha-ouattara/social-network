$(function(){
    // If the user is authenticated
    if(document.cookie.indexOf('authtoken') > -1 ){
        // Create socket
        socket = io.connect('http://localhost:443')
        // Solve async issue
        socket.on('connect', () =>{
            $.post(
                'model/data/Server.php',
                {authtoken :  Cookies.get('authtoken')},
                function(data){
                    socket.emit('data', data)
                }
            )
        })

        // When a friend connects or disconnects
        socket.on('friend_pop', ()=>{
            $("#friends_list").load(' #friends_list > *')
            $(".friend_status").load(' .friend_status')
        })
        
        // When a new message has been received
        socket.on('newmsg', (message)=>{
            // Refresh actual message window
            $('#section_messages').load(' #section_messages > *', appendEmojisMenu)
            console.log('newmsg')
            // Refresh conversation resume
            $('a[href="messages&conversation=' + message.conversation + '"]').load(location.href + ' a[href="messages&conversation=' + message.conversation + '"]')
        })

        // Refresh div when an emoji has been sent to a message
        socket.on('emoji', (message)=>{
            $('#' + message).load(' #' + message)
        })
    }
    // Delete socket if authtoken cookie isn't valid
    else if(typeof socket != 'undefined') delete(socket)

    /**
     * Messages handling
     */
    $(document).on('submit', '#messager', function(e){
        e.preventDefault()
        // Create message object {content, from, to, conversation}
        var message = {}
        message.content = $('#input_m').val()
        message.from = user
        message.to = partner
        message.conversation = conversation
        // If message isn't empty
        if(message.content.length){
            $.post(
                'model/social/Message.php', 
                {user, partner, message:message.content, conversation}, 
                (data)=>{
                    // console.log(data)
                    $('#section_messages').load(' #section_messages > *', appendEmojisMenu)
            })
            // Clear input and set focus
            $('#input_m').val('').trigger('focus')
            // Emit message to the server
            socket.emit('message', message)
        }
        // Else
        else{}
    })
})