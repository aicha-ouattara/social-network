// var jsdom = require("jsdom");
// const { JSDOM } = jsdom;
// const { window } = new JSDOM();
// const { document } = (new JSDOM('')).window;
// global.document = document;

// var $ = jQuery = require('jquery')(window);

const express = require('express')
const app = express()
const http = require('http')
const server = http.createServer(app)
users = {}
prevent = false

const io = require("socket.io")(server, {
    cors: {
      origin: "*",
      methods: ["GET", "POST"]
    }
})

// User connected
io.on('connection', (socket)=>{
    // User authentified
    socket.on('data', (data)=>{
        // convert data to object {authtoken, id, login}
        // pers used just to show $user connected & $user disconnected  
        var pers = ''
        data = JSON.parse(data)
        for(var id in users){
            if(users[id].login === data.login){
                typeof discUser !== 'undefined' ? clearTimeout(discUser) : null
                pers = 'connected'
                delete users[id]
                break
            }
        }
        users[socket.id] = data
        pers !== 'connected' ? console.log(users[socket.id].login + ' connected') : null
        pers = ''
    })
    // User disconnected
    socket.on('disconnect', ()=>{
        discUser = setTimeout(() => {
            if(socket.id in users){
                console.log(users[socket.id].login + ' disconnected')
                delete users[socket.id]
            }
        }, 3000)
    })
    // Receiving message
    socket.on('message', (message)=>{
        io.emit('newmsg', message)
    })
})

server.listen(443, 'localhost')