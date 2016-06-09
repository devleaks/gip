socket = comet.connect();
  socket.on('connect', function() {
    // do something when it's connected for the first time 
  }).on('test.message', function (data) {
    // do something, such as sending an message to the server 
    socket.emit('test.response', { something:'any json object' });
  });