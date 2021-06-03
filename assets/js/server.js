const Database = require('./classes/Database.js')
const User = require('./classes/User.js')

link = new Database()
database = link.database

const express = require('express')
const app = express()
const http = require('http')
const { connect } = require('http2')

const server = http.createServer(app)
const io = require("socket.io")(server, {
    cors: {
      origin: "*",
      methods: ["GET", "POST"]
    }
})

users = {}
user = {}
friends = []
prevent = false

// User connected
io.on('connection', (socket)=>{
    // User authentified
    socket.on('data', (data)=>{
        // Convert data to object {authtoken, id, login}
        data = JSON.parse(data)
        // $pers used just to show $user connected & $user disconnected  
        var pers = ''
        for(let id in users){
            if(users[id].login === data.login){
                typeof discUser !== 'undefined' ? clearTimeout(discUser) : null
                pers = 'connected'
                delete users[id]
                break
            }
        }
        users[socket.id] = data
        // Create user on server' side
        user = new User(data.id, data.login, data.authtoken)
        // Set user's status to online
        user.connect()
        // Fetch friends to call the connection
        user.getFriends(function(result){
            friends = result
            for(let socketid in users){
                if(friends.includes(parseInt(users[socketid].id))) io.to(socketid).emit('friend_pop')
            }
        })

        pers !== 'connected' ? console.log(users[socket.id].login + ' connected') : null
        pers = ''
    })
    // User disconnected
    socket.on('disconnect', ()=>{
        discUser = setTimeout(() => {
            if(socket.id in users){
                console.log(users[socket.id].login + ' disconnected')
                for(let socketid in users){
                    if(friends.includes(parseInt(users[socketid].id))) io.to(socketid).emit('friend_pop')
                }
                user.disconnect()
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