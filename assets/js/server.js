const express = require('express')
const app = express()
const http = require('http')
const server = http.createServer(app)
users=[]
prevent = false

const io = require("socket.io")(server, {
    cors: {
      origin: "*",
      methods: ["GET", "POST"]
    }
})
  
// User connected
io.on('connection', (socket)=>{
    socket.on('authtoken', (data)=>{
        if(users.includes(data)){
            clearTimeout(discUser)
            prevent = true
        }
        else{
            users.splice(socket.id, 0, data)
        }
    })
    // Receiving message
    socket.on('message', (message)=>{
        io.emit('newmsg', message)
    })
    // User disconnected
    socket.on('disconnect', ()=>{
        discUser = setTimeout(() => {
            if(users.indexOf(socket.id) && prevent === false){
                users.splice(socket.id, 1)
                console.log('disconnect ' + users)
            }
        }, 3000)
        prevent = false
    })
    console.log('users = ' + users)
})

server.listen(443, 'localhost')