const amqpvhost = '/'
const port = 3001
const debug = true

var amqp = require("amqp")
var config = require("config")
var rmq = amqp.createConnection({host: config.rmq.host, vhost: config.rmq.vhost, login: config.rmq.login, password: config.rmq.password})

var fs = require('fs')
var app = require("express")()
var server = require("http").createServer(app)
var io = require("socket.io").listen(server)

io.on('connection', function(socket) {
	console.log('User connected')
	socket.on('disconnect', function() {
		console.log('User disconnected')
	})
	socket.on('join', (room) => {
		if (typeof room === 'string' && room.length >= 2 && room.length <= 50) {
			socket.join(room)
			console.log('User join to room: ' + room)
		}
	})
	socket.on('leave', (room) => {
		if (typeof room === 'string' && room.length >= 2 && room.length <= 50) {
			if (typeof socket.rooms[room] !== 'undefined') {
				socket.leave(room)
				console.log('User leave to room: ' + room)
			}
		}
	})
})

var send = (m) => {
	var event = (typeof m.event === 'string') ? m.event : 'message'
	if (typeof m.rooms === 'string') {
		io.to(m.rooms).emit(event, m.data)
		if (debug !== false) {
			console.log('Send to room: ' + m.rooms + ', event: ' + event)
		}
	} else if (typeof m.rooms === 'object') {
		for (var i in m.rooms ) {
			var room = m.rooms[i]
			if (typeof room === 'string') {
				io.to(room).emit(event, m.data)
				if (debug !== false) {
					console.log('Send to room: ' + room + ', event: ' + event)
				}
			} else {
				console.log(room)
				console.log('Room not String!')
			}
		}
	} else {
		io.sockets.emit(event, m.data)
		if (debug !== false) {
			console.log('Send to all, event: ' + event)
		}
	}
}

rmq.on("ready", function () {
	// wait for connected users, 5 sec
	console.log('Wait 5 seconds...')
	setTimeout(() => {
		var queue = rmq.queue("comet", {durable: true, autoDelete: false}, function () {
			queue.bind("#"); // to all messages
			queue.subscribe(function (m) {
				try {				
					m = JSON.parse(m.data.toString())
					if (debug !== false) {
						console.log(m)
					}
					if (m && m.data) {
						if (typeof m.delay === 'number' && m.delay > 0 && m.delay <= 60000) {
							if (debug !== false) {
								console.log('Send with delay: ' + m.delay)
							}
							setTimeout(() => {
								if (debug !== false) {
									console.log('Delay finished: ' + m.delay)
								}
								send(m) 
							}, m.delay)
						} else {
							send(m)
						}
					}

				} catch (err) {
					console.log(err)
				}
			})
		})
	}, 1000)
})

server.listen(port)
console.log("Listening on *:" + port)