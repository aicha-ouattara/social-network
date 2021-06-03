const mysql = require('mysql')
const options = {
    host    : 'localhost',
    user    : 'root',
    password: '',
    database: 'socialnetwork'
}

class Database{
    constructor(){
        this.database = mysql.createConnection(options)
    }
}

module.exports = Database