var app = require('http').createServer(handler);
var file = new(require('node-static').Server)(__dirname + '/web', {});
var comet = require('comet.io').createServer();
 
app.listen(8000);
function handler(request, response) {
  request.on('end', function() {
    if (!comet.serve(request, response)) {
      file.serve(request, response, function(err, res) {
        if (err) { console.log(err); }
      });
    } 
  });
}
 
comet.on('connection', function (socket) {
  // do something when a client has connected 
  socket.emit('test.message', { something:'any json object here' });
 
  socket.on('test.response', function(data) {
    // do something when it receives a message from client 
  });
});