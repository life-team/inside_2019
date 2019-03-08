// npm install config
var config = require('config')
var dbConfig = config.get('db')

// npm install mysql
var mysql = require('mysql')

// npm install util
var util = require('util')

var connect = mysql.createConnection(dbConfig)

connect.connect((err, connection) => {
    if (err) {
        if (err.code === 'PROTOCOL_CONNECTION_LOST') {
            console.error('Database connection was closed.')
        }
        if (err.code === 'ER_CON_COUNT_ERROR') {
            console.error('Database has too many connections.')
        }
        if (err.code === 'ECONNREFUSED') {
            console.error('Database connection was refused.')
        }
        if (connection) connection.release()
        return
    }
})

connect.query = util.promisify(connect.query)

connect.beginTransaction = util.promisify(connect.beginTransaction)
connect.commit = util.promisify(connect.commit)
connect.rollback = util.promisify(connect.rollback)

module.exports = connect

