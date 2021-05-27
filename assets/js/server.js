const express = require('express')
const app = express()
const http = require('http')
const server = http.createServer(app)
const io = require("socket.io")(server, {
    cors: {
      origin: "*",
      methods: ["GET", "POST"]
    }
})
  

io.on('connection', (socket)=>{
    console.log('user connected')
    socket.on('disconnect', ()=>{
        
    })
})

server.listen(443, 'localhost', ()=>{
    console.log('listening on 443')
})