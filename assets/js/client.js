$(function(){
    /**
     * Connection handling
     */
    if(document.cookie.indexOf('authtoken') > -1 ){
        socket = io.connect('http://localhost:443')
        socket.on('connect', () =>{
            $.post(
                'model/data/Server.php',
                {authtoken :  Cookies.get('authtoken')},
                function(data){
                    socket.emit('data', data)
                }
            )
            // typeof Cookies.get('socketid') == 'undefined' ? Cookies.set('socketid', socket.id, { expires: 7, path: '/', secure: true, sameSite: 'strict' }) : null
            // socket.id = Cookies.get('socketid')
        })
        
        socket.on('newmsg', function(message){
            $('#section_messages').load(location.href + ' #section_messages')
        })
    }
    else if(typeof socket != 'undefined') delete(socket)

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
})