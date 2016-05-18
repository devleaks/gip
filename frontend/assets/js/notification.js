$( document ).ready(function() {

    var socket = io.connect('http://iMac.local:8890');

    socket.on('notification', function (data) {

        var message = JSON.parse(data);

        $( "#notifications" ).prepend( "<p><strong>" + message.name + "</strong>: " + message.message + "</p>" );

    });

});