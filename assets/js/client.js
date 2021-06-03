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
        })
        
        // When a new message has been received
        socket.on('newmsg', function(message){
            $('#section_messages').load(location.href + ' #section_messages')
        })
    }
    // Delete socket if authtoken cookie isn't valid
    else if(typeof socket != 'undefined') delete(socket)

    /**
     * Messages handling
     */
    $('#messager').on('submit', function(e){
        e.preventDefault()
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