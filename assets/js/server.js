const Database = require('./classes/Database.js')
const User = require('./classes/User.js')

const link = new Database()
const database = link.database

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

// User connected
io.on('connection', (socket)=>{
    // User authentified
    socket.on('data', (data)=>{
        // Convert data to object {authtoken, id, login}
        data = JSON.parse(data)
        // $pers used just to show $user connected & $user disconnected  
        var pers = ''
        // Loop through users & delete previous entry if it exists
        for(let socketid in users){
            if(users[socketid].login === data.login){
                typeof discUser !== 'undefined' ? clearTimeout(discUser) : null
                pers = 'connected'
                delete users[socketid]
                break
            }
        }
        // Insert {id, login, authtoken} into users array
        users[socket.id] = data
        // Create user on server' side
        user = new User(data.id, data.login, data.authtoken)
        // Set user's status to online
        user.connect()
        // Fetch friends to call the connection
        user.getFriends(function(result){
            friends = result
            for(let socketid in users){
                if(friends.includes(parseInt(users[socketid].id))){
                    io.to(socketid).emit('friend_pop')
                }
            }
        })

        pers !== 'connected' ? console.log(users[socket.id].login + ' connected') : null
        pers = ''
    })
    // User sent an emoji
    socket.on('emoji', (data)=>{
        for(let socketid in users){
            if(data.partner == users[socketid].id){
                io.to(socketid).emit('emoji', data.message)
            }
        }
    })
    // User disconnected
    socket.on('disconnect', ()=>{
        /**
         * Each refresh is considered as a disconnect/connect
         * Hence a timeout with a cleartimeout at the connect event will prevent this from happening
         */
        discUser = setTimeout(() => {
            // Verify that there is an actual user to disconnect
            if(socket.id in users){
                console.log(users[socket.id].login + ' disconnected')
                // Redeclare user to avoid confusion
                user = new User(users[socket.id].id, users[socket.id].login, users[socket.id].authtoken)
                // Disconnect the user
                user.disconnect()
                // Fetch friends
                user.getFriends(function(result){
                    friends = result
                    for(let socketid in users){
                        if(friends.includes(parseInt(users[socketid].id))){
                            io.to(socketid).emit('friend_pop')
                        }
                    }
                })
                // Delete the user from the users array
                delete users[socket.id]
            }
        }, 3000)
    })
    // Receiving message
    socket.on('message', (message)=>{
        // Emit the message to concerned user
        for(let socketid in users){
            if(users[socketid].id == message.to){
                io.to(socketid).emit('newmsg', message)
            }
        }
        io.to(socket).emit('newmsg', message)
    })
})

server.listen(443, 'localhost')