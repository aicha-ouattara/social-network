Database = require('./Database.js')

class User extends Database{
    constructor(id, login, authtoken){
        super()
        this.id = id
        this.login = login
        this.authtoken = authtoken
    }

    connect(){
        this.database.query(
            `UPDATE users
            SET online = 1 
            WHERE login = ?`,
            [this.login],
            (error, results)=>{
                if(error) throw error.message
                // console.log(results)
            }
        )
    }

    disconnect(){
        this.database.query(
            `UPDATE users
            SET online = 0 
            WHERE login = ?`,
            [this.login],
            (error, results)=>{
                if(error) throw error.message
                // console.log(results)
            }
        )
    }

    getFriends(callback){
        this.followers = []
        this.followings = []
        this.database.query(
            `SELECT f.id_followed
            FROM follows f
            INNER JOIN users u 
            ON f.id_following = u.id
            WHERE f.id_following = ? AND u.online = 1`,
            [this.id],
            (error, rows)=>{
                if(error) throw error.message
                rows.forEach(element => {
                    this.followers.push(element.id_followed)
                })
                this.database.query(
                    `SELECT f.id_following
                    FROM follows f
                    INNER JOIN users u 
                    ON f.id_followed = u.id
                    WHERE f.id_followed = ? AND u.online = 1`,
                    [this.id],
                    (error, rows)=>{
                        if(error) throw error.message
                        rows.forEach(element => {
                            this.followings.push(element.id_following)
                        })
                        const friends = this.followers.filter(value => this.followings.includes(value))
                        return callback(friends)
                        // return callback(this.followings)
                    }
                )
                // return callback(this.followers)
            }
        )
        
    }
}

module.exports = User