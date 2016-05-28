$(function(){
	priority_map = [
		'default',
		'info',
		'success',
		'primary',
		'warning',
		'danger'
	];
	intro_messages = {
		opening: {
			subject: 'Opening connection...',
			body: '... connected.',
			priority: 1,
			source: 'websocket',
			type: 'warning',
			color: '#0f0'
		},
		closing: {
			subject: 'Closing connection...',
			body: 'Connection closed. Trying to reconnect...',
			priority: 1,
			source: 'websocket',
			type: 'warning',
			color: '#f00'
		},
		starting: {
			subject: 'Connection',
			body: 'Connecting to server...',
			priority: 1,
			source: 'websocket',
			type: 'info',
			color: '#aa0'
		}
	};
	function addWire(message) {
		bs_color = priority_map[message.priority % 6];
		//console.log(message);
		$('<li>')
		.append(
			$('<i>').addClass('fa').addClass(message.icon).css('bg-color', message.color).html(' ')
		)
		.append( $('<div>').addClass('timeline-item').addClass('timeline-danger')
			.append( $('<span>').addClass('time')
				.append(
					$('<i>').addClass('fa').addClass('fa-clock-o')
				).append(' '+moment(new Date()).format('ddd D MMM YY H:mm'))
			)
			.append( $('<h3>').addClass('timeline-header').html(message.subject) )
			.append( $('<div>').addClass('timeline-body').html(message.body + '<br/>' + JSON.stringify(message)) )
			.append( $('<div>').addClass('timeline-footer')
				.append(
					$('<a>').addClass('btn').addClass('btn-'+bs_color).addClass('btn-xs').html('Published on '+moment(message.created_at).format('ddd D MMM YY H:mm'))
				)
			)
		)
		.prependTo("#the-wire").hide().slideDown();
	};
	
	$('form#wire-chat-form').submit(function(){
		msg = {
			subject: 'Chat message',
			body: $('#wire-chat-inputext').val(),
			priority: 1,
			source: 'websocket',
			icon: 'fa-comments',
			type: 'info',
			color: '#00f',
			created_at: new Date()
		};
		console.log(JSON.stringify(msg));
		ws.send(JSON.stringify(msg));
		$('#wire-chat-inputext').val('');
		return false;
	});
	
	$('input.wire-checkbox').click(function() {
		vid = $(this).data('message');
		$.post(
			'/gipadmin/site/read',
            {
				id: vid
			},
   			function () {
				console.log('read '+vid);
            }
		);
		$(this).prop('disabled', true);
	});

    function wsStart() {
		ws = new WebSocket('ws://imac.local:8051/');
        ws.onopen = function() { intro_messages.opening.created_at = new Date(); addWire(intro_messages.opening); };
        ws.onclose = function() { intro_messages.closing.created_at = new Date(); addWire(intro_messages.closing); };
        ws.onmessage = function(evt) {
			addWire($.parseJSON(evt.data));
			$('#the-wire').scrollTop($('#the-wire')[0].scrollHeight);
		};
    }

	intro_messages.starting.created_at = new Date(); 
	addWire(intro_messages.starting);	
    wsStart();
});