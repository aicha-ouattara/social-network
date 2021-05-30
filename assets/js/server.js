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
    socket.on('authtoken', (data)=>{
        if(Object.values(users).indexOf(data) > -1){
            clearTimeout(discUser)
        }
        else{
            users[socket.id] = data
        }
    })
    // User disconnected
    socket.on('disconnect', ()=>{

        // En retard de 1
        console.log(socket.id)
        discUser = setTimeout(() => {
            if(socket.id in users){
                delete users[socket.id]
                console.log(socket.id + ' disconnected')
            }
        }, 3000)
    })
    // Receiving message
    socket.on('message', (message)=>{
        io.emit('newmsg', message)
    })
})

server.listen(443, 'localhost')