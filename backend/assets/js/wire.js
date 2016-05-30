/**
	Add messages to wire.

	Message structure:
	{
		"id":1,

		"subject":"Le passage de Lorem Ipsum standard, utilisé depuis 1500",
		"body":"Lorem ipsum dolor sit amet,	consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
		"link":"http://linktonowhere/",

		"source":"GIP",
		"type":"notification"
		"priority":2,

		"icon":"fa-comment",
		"color":"#00ff00",

		"tags":"airport,delay",

		"note":"Debug text",

		"expired_at":null,
		"ack_at":null,

		"created_at":"2016-03-04 08:42:54",
		"updated_at":"2016-03-04 08:42:54",

		"status":"PUBLISHED"
	}

 */
$(function() {
	// Plugin Defaults
	defaults = {
		debug: false,
		id: "the-wire",
		// Websocket feeds
		websocket: 'ws://imac.local:8051/',
		initSeed: '',///gipadmin/wire/seed
		markRead: '/gipadmin/wire/read',
		// General presentation
		color: '#bbb',
		size: 'medium',
		speed: 500,
		// More
		numWords: 50,
		ellipsestext: '<i class="fa fa-ellipsis-h"></i>',
		moretext: '<i class="fa fa-angle-double-right"></i>',
		lesstext: '<i class="fa fa-angle-double-left"></i>',  
		priority_map: [
			'default',
			'info',
			'success',
			'primary',
			'warning',
			'danger'
		],
		// Debug
		intro_messages: {
			opening: {
				subject: 'Opening connection...',
				body: '... connected.',
				priority: 1,
				source: 'websocket',
				type: 'warning',
				icon: 'fa-info',
				color: 'success'
			},
			closing: {
				subject: 'Closing connection...',
				body: 'Connection closed. Trying to reconnect...',
				priority: 1,
				source: 'websocket',
				type: 'warning',
				icon: 'fa-info',
				color: '#ff0'
			},
			starting: {
				subject: 'Connection',
				body: 'Connecting to server...',
				priority: 1,
				source: 'websocket',
				type: 'info',
				icon: 'fa-info',
				color: '#0f0'
			}
		}
	};

	// Timestamp of last addition. Used to make date markers.
	var last_add = null;
		

	// Main subroutine
	function addWire(message) {
		var tags = new Array();
		// Priority
		var priority = message.priority == null ? 0 : parseInt(message.priority);
		if(priority > 5) priority = 5;
		var bs_color = defaults.priority_map[priority % 6];
		var priority_string = '';
		for(i=0; i<priority; i++)
			priority_string += '<i class="fa fa-star"></i>';
		for(i=priority; i<6; i++)
			priority_string += '<i class="fa fa-star-o"></i>';
		priority_string += '&nbsp;';
		tags.push('p'+priority);
		tags.push(message.source);
		tags.push(message.type);


		// Color
		if(message.color.substr(0, 1) != '#' && $.inArray(message.color, defaults.priority_map)) { // uses bootstrap color
			console.log('uses bs color');
			message.color = defaults.color;
		}
		
		// Icon
		
				
		// Link
		console.log(tags.join(','));
		title = message.subject;
		if(message.link) {
			title = $('a').attr('href', message.link);
		}

		// Body
		text = message.body;
		if(defaults.numWords > 0) {
			var content = text.split(" ");
			if(content.length > defaults.numWords) {
				var c = content.slice(0,defaults.numWords).join(" ");
				var h = content.slice(defaults.numWords,content.length).join(" ");
				text = c + '&nbsp;<span class="moreelipses">'+defaults.ellipsestext+'</span>&nbsp;<span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="" class="morelink">'+defaults.moretext+'</a></span>';
			}
		}

		// Assembly
		$('<li>')
		.append(
			$('<i>').addClass('fa').addClass(message.icon).css('background-color', message.color).html(' ')
		)
		.append( $('<div>').addClass('timeline-item').addClass('timeline-'+bs_color)
			.append( $('<span>').addClass('time')
				.append(priority_string)
				.append(
					$('<i>').addClass('fa').addClass('fa-clock-o')
				).append(' '+moment(new Date()).format('ddd D MMM YY H:mm'))
			)
			.append( $('<h3>').addClass('timeline-header').html(title) )
			.append( $('<div>').addClass('timeline-body').addClass('more').html(defaults.debug ? text + '<br/>' + JSON.stringify(message) : text) )
			.append( $('<div>').addClass('timeline-footer')
				.append(
					$('<a>').addClass('btn').addClass('btn-'+bs_color).addClass('btn-xs').html('Published on '+moment(message.created_at).format('ddd D MMM YY H:mm'))
				)
			)
		)
		.addClass('wire-message')
		.attr('data-item-tags', tags.join(',').toLowerCase())
		.prependTo("#"+defaults.id).hide().slideDown(defaults.speed);
		
		// Cleanup
		last_add = new Date();
		// Rebuild task list
		$('div.tagsort-tags-container').html('').tagSort({
			items:'.wire-message'
		});
		$(".morelink").click(function(){
			if($(this).hasClass("less")) {
				$(this).removeClass("less");
				$(this).html(defaults.moretext);
			} else {
				$(this).addClass("less");
				$(this).html(defaults.lesstext);
			}
			$(this).parent().prev().toggle();
			$(this).prev().toggle();
			return false;
		});
		
	};
	

	// Acknowledge Checkbox
	$('input.wire-checkbox').click(function() {
		vid = $(this).data('message');
		$.post(
			defaults.markRead,
            {
				id: vid
			},
   			function () {
				console.log('read '+vid);
            }
		);
		$(this).prop('disabled', true);
	});
	

	// More... (only works with plain text)
	// Chops text
	$('.more').each(function() {
		var content = $(this).html().split(" ");
		if(content.length > defaults.numWords) {
			var c = content.slice(0,defaults.numWords).join(" ");
			var h = content.slice(defaults.numWords,content.length).join(" ");
			var html = c + '&nbsp;<span class="moreelipses">'+defaults.ellipsestext+'</span>&nbsp;<span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="" class="morelink">'+defaults.moretext+'</a></span>';
			$(this).html(html);
		}
	});
	
	$(".morelink").click(function(){
		if($(this).hasClass("less")) {
			$(this).removeClass("less");
			$(this).html(defaults.moretext);
		} else {
			$(this).addClass("less");
			$(this).html(defaults.lesstext);
		}
		$(this).parent().prev().toggle();
		$(this).prev().toggle();
		return false;
	});
	
	// Init & start ws connection
    function wsStart() {
		ws = new WebSocket(defaults.websocket);
        ws.onopen = function() { defaults.intro_messages.opening.created_at = new Date(); addWire(defaults.intro_messages.opening); };
        ws.onclose = function() { if(defaults.debug) { defaults.intro_messages.closing.created_at = new Date(); addWire(defaults.intro_messages.closing); } };
        ws.onmessage = function(evt) {
			addWire($.parseJSON(evt.data));
			$('#'.defaults.id).scrollTop($('#'+defaults.id)[0].scrollHeight);
		};
    }

	// Fetches last messages (if url provided). Displays them all.
	function initSeed() {
		if(defaults.initSeed.length > 0) {
			$.post(
				defaults.initSeed,
	            {},
	   			function (r) {
					msgs = $.parseJSON(r);
					for(var idx=msgs.length - 1;idx>= 0;idx--) { // oldest first
						addWire(msgs[idx]);
					}
	            }
			);
			
		}
	}

	// Main
	if(defaults.debug) {
		defaults.intro_messages.starting.created_at = new Date(); 
		addWire(defaults.intro_messages.starting);
	}
    wsStart();
	initSeed();

});