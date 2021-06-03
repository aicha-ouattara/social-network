$(function(){
    /**
     * Connection handling
     */
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
            $("#friends_list").load(location.href + ' #friends_list')
            $("#friend_conversation").load(location.href + ' #friend_conversation')
        })
        
        // When a new message has been received
        socket.on('newmsg', (message)=>{
            // Refresh actual message window
            $('#section_messages').load(location.href + ' #section_messages')
            // Refresh conversation resume
            $('a[href="messages&conversation=' + message.conversation + '"]').load(location.href + ' a[href="messages&conversation=' + message.conversation + '"]')
        })
    }
    // Delete socket if authtoken cookie isn't valid
    else if(typeof socket != 'undefined') delete(socket)

    /**
     * Messages handling
     */
    $('#messager').on('submit', function(e){
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
                ()=>{
                    $('#section_messages').load(location.href + ' #section_messages')
            })
            // Clear input and set focus
            $('#input_m').val('').trigger('click')
            // Emit message to the server
            socket.emit('message', message)
        }
        // Else
        else{}
    })
})