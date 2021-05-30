$(function(){
    if(document.cookie.indexOf('authtoken') > -1 ){
        socket = io.connect('http://localhost:443')
        socket.on('connect', () =>{
            socket.emit('authtoken', Cookies.get('authtoken'))
            typeof Cookies.get('socketid') == 'undefined' ? Cookies.set('socketid', socket.id, { expires: 7, path: '/', secure: true, sameSite: 'strict' }) : null
            console.log(socket.id)
            socket.id = Cookies.get('socketid')
            console.log(socket.id)
        })
        
        socket.on('newmsg', function(message){
            $('#section_messages').load(location.href + ' #section_messages')
        })
    }
    else{
        typeof Cookies.get('socketid') != 'undefined' ? Cookies.remove('socketid') : null
        typeof socket != 'undefined' ? delete(socket) : null
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
})