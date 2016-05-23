var io = require('socket.io').listen(3131);
 
io.sockets.on('connection', function (socket) {
 
  var max = 100
 
  // generate a sample every second
    setInterval(function() {
        var x = (new Date()).getTime(), // current time
            y = Math.floor((Math.random() * max) + 1);
        socket.emit('sample', {
        	x: x,
        	y: y
        });
        console.info("emitted: [" + x + "," + y + "]");
    }, 1000);
});