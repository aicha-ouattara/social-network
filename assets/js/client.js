$(function(){
    const socket = io.connect('http://localhost:443')

    $('#messager').on('submit', function(e){
        e.preventDefault()
        console.log($('#input_m').val())
    })
})