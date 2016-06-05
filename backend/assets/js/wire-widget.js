/*
 * jQuery Wire Widget
 * 2016 Pierre M
 * License: MIT
 */
 
(function($) {
	"use strict";

	/*
	 * Default Values
	 */
	var opts;
	var lastDateReminder = null;
	var defaults = {
		debug: false,
		id: "the-wire",
		// Websocket feeds
		websocket: 'ws://localhost:8051/',
		initSeed: '',///gipadmin/wire/seed
		markRead: '/gipadmin/wire/read',
		moreOlder: '',///gipadmin/wire/older
		// General presentation
		color: '#bbb',
		size: 'medium',
		speed: 500,
		// More
		numWords: 50,
		dateReminder: 3, // minutes
		ellipsestext: '<i class="fa fa-ellipsis-h"></i>',
		moretext: '<i class="fa fa-angle-double-right"></i>',
		lesstext: '<i class="fa fa-angle-double-left"></i>',
		ignoreTags: ['default','unknown'],
		filterNewMessage: false,
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
		},
		marker_beacons: {
			inner: {
				count: 12,
				speed: 'fast'
			},
			middle: {
				count: 7,
				speed: 'medium'
			},
			outer: {
				count: 5,
				speed: 'slow'
			}
		},
		soundFileLocation: ''
	};

	/*
	 * Only gets called when we're using $('$el').wireWidget format
	 */
	var WireWidget = function() {
		
	}
	
	WireWidget.prototype.init = function(options) {
		opts = $.extend( {}, defaults, options);
		if(opts.debug) {
			opts.intro_messages.starting.created_at = new Date(); 
			WireWidget.prototype.addWire(opts.intro_messages.starting);
		}
		install();
	    wsStart();
		initSeed();
	};
	
	/*
	 * Utility Function
	 */
	//Fields have id='source-type-name'.
	function updateFields(msg) {
		var payload = $.parseJSON(msg.body);
		var prefix  = msg.source.toLowerCase() + '-' + msg.type.toLowerCase() + '-';
		for (var property in payload) {
			if (payload.hasOwnProperty(property)) {
				$('#' + prefix + property).html(payload[property]);
		    }		
		}
	}
	
	function updateMarkers(msg) {
		var payload = $.parseJSON(msg.body);
		$('#marker-left').html(payload.value + ' L');
		$('#marker-right').html(payload.value + ' R');
	}

	//Fields of type marker
	function blink(selector, marker, count) {
		if(count > opts.marker_beacons[marker]['count']) return;
		$(selector).fadeOut(opts.marker_beacons[marker]['speed'], function(){
		    $(this).fadeIn(opts.marker_beacons[marker]['speed'], function(){
		        blink(this, marker, count + 1);
		    });
		});
	}

	function play_sound(marker) {
		var soundUrl = opts.soundFileLocation + marker + '.m4a';
		var audio = new Audio();
        audio.src = soundUrl;
        audio.play();
	}

	function flash_marker(msg) {
		var marker = msg.type.toLowerCase();
		var side = msg.body.toLowerCase();
		if(side.length == 0) // defaults to right
			side = 'right';
		play_sound(marker);
		blink(".marker-"+marker+'.marker-'+side, marker, 0);
	}

	// Init & install a few hooks
	function install() {
		// Acknowledge Checkbox
		$('input.wire-checkbox').click(function() {
			vid = $(this).data('message');
			$.post(
				opts.markRead,
	            {
					id: vid
				},
	   			function () {
					console.log('marked as read '+vid);
	            }
			);
			$(this).prop('disabled', true);
		});

		// More... (only works with plain text)
		// Chops text
		$('.wire-more').each(function() {
			var content = $(this).html().split(" ");
			if(content.length > opts.numWords) {
				var c = content.slice(0,opts.numWords).join(" ");
				var h = content.slice(opts.numWords,content.length).join(" ");
				var html = c + '&nbsp;<span class="wire-more-elipses">' + opts.ellipsestext
							 + '</span>&nbsp;<span class="wire-more-content"><span>'
							 + h + '</span>&nbsp;&nbsp;<a href="" class="wire-more-link">'
							 + opts.moretext + '</a></span>';
				$(this).html(html);
			}
		});

		$(".wire-more-link").click(function(){
			if($(this).hasClass("wire-less")) {
				$(this).removeClass("wire-less");
				$(this).html(opts.moretext);
			} else {
				$(this).addClass("wire-less");
				$(this).html(opts.lesstext);
			}
			$(this).parent().prev().toggle();
			$(this).prev().toggle();
			return false;
		});

	};

	// Init & start ws connection
    function wsStart() {
		var ws = new WebSocket(opts.websocket);
        ws.onopen = function() { opts.intro_messages.opening.created_at = new Date(); WireWidget.prototype.addWire(opts.intro_messages.opening); };
        ws.onclose = function() { if(opts.debug) { opts.intro_messages.closing.created_at = new Date(); WireWidget.prototype.addWire(opts.intro_messages.closing); } };
        ws.onmessage = function(evt) {
			var msg = $.parseJSON(evt.data);
			switch(msg.source.toLowerCase()) {
				case 'aodb':
					switch(msg.type.toLowerCase()) {
						case 'qfu':
							updateFields(msg);
							updateMarkers(msg);
							msg.body = ''; // reset body to empty
						default:
							WireWidget.prototype.addWire(msg);
							$('#'+opts.id).scrollTop($('#'+opts.id)[0].scrollHeight);
							break;
					}
					break;
				case 'marker':
					flash_marker(msg);
					if(msg.type.toLowerCase() == 'outer') {
						WireWidget.prototype.addWire(msg);
					}
					break;
				default:
					WireWidget.prototype.addWire(msg);
					$('#'+opts.id).scrollTop($('#'+opts.id)[0].scrollHeight);
					break;
			}
		};
    }

	// Fetches last messages (if url provided). Displays them all.
	function initSeed() {
		if(opts.initSeed.length > 0) {
			$.post(
				opts.initSeed,
	            {},
	   			function (r) {
					msgs = $.parseJSON(r);
					for(var idx=msgs.length - 1;idx>= 0;idx--) { // oldest first
						WireWidget.prototype.addWire(msgs[idx]);
					}
	            }
			);

		}
	}


	/*
	 * Main API polling function
	 */
	WireWidget.prototype.addWire = function(message) {
		var tags = new Array();
		var addTags = function(str) {
			if(opts.ignoreTags.indexOf(str) == -1)
				tags.push(str);
		}

		// Priority
		var priority = message.priority == null ? 0 : parseInt(message.priority);

		if(priority < 0)	// convention: we do not display wire message with negative priority on the wire.
			return; 		// they are handled by other giplet handlers, but they are not displayed on the wire.
		if(priority > (opts.priority_map - 1))
			priority = opts.priority_map - 1;

		var priority_string = '★'.repeat(priority)+'☆'.repeat(5-priority);

		addTags(priority_string);
		addTags(message.source.toLowerCase());
		addTags(message.type.toLowerCase());
		var bs_color = opts.priority_map[priority % opts.priority_map.length];


		// Color
		if(message.color.substr(0, 1) != '#' && $.inArray(message.color, opts.priority_map)) { // uses bootstrap color
			//console.log('uses bs color');
			message.color = opts.color;
		}

		// Icon


		// Link
		var title = message.subject;
		if(message.link) {
			title = $('<a>').attr('href', message.link).html('<i class="fa fa-link"></i>&nbsp;' + message.subject);
		}

		// Body
		var text = message.body;

		// special message parsing
		if(message.type.toLowerCase() == 'metar') {
			var metar = metar_decode(text);
			if(metar.length > 0) {
				text = metar.replace(/(?:\r\n|\r|\n)/g, '<br />') + '<br/><pre>'+text+'</pre>';
			}
		}
		// text shortening
		if(opts.numWords > 0) {
			var content = text.split(" ");
			if(content.length > opts.numWords) {
				text = content.slice(0,opts.numWords).join(" ")
						 + '&nbsp;<span class="wire-more-elipses">' + opts.ellipsestext
						 + '</span>&nbsp;<span class="wire-more-content"><span>'
						 + content.slice(opts.numWords,content.length).join(" ")
						 + '</span>&nbsp;&nbsp;<a href="" class="wire-more-link">'
						 + opts.moretext + '</a></span>';
			}
		}

		// Do we need a new Date reminder in the margin?
		if(lastDateReminder == null || ((Date() - lastDateReminder) > (opts.dateReminder * 60000)) ) {
			$('<li>').addClass('time-label')
					.append($('<span>').addClass('bg-blue').html(moment().format("ddd D MMM H:mm")))
					.prependTo("#"+opts.id);
			lastDateReminder = new Date();
		}

		// Assembly
		var tagPills = $('<span>');
		for(var idx = 0; idx < tags.length; idx++) {
			tagPills.append($('<span>').addClass('label').addClass('label-default').html(tags[idx])).append('&nbsp;');
		}

		/* madminLTE timeline structure
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
					.append( $('<div>').addClass('timeline-body').addClass('wire-more').html(opts.debug ? text + '<br/>' + JSON.stringify(message) : text) )
					.append( $('<div>').addClass('timeline-footer')
						.append(tagPills)
						.append(
							$('<span>').addClass('label').addClass('label-'+bs_color).html('Published on '+moment(message.created_at).format('ddd D MMM YY H:mm'))
						)
					)
				)
				.addClass('wire-message')
				.attr('data-item-tags', tags.join(',').toLowerCase())
				.attr('id', 'wire-message-'+message.id)
				.prependTo("#"+opts.id).hide().slideDown(opts.speed);

		<li class="timeline-inverted">
			<div class="timeline-circ circ-xl style-primary"><span class="glyphicon glyphicon-leaf"></span></div>
			<div class="timeline-entry">
				<div class="card style-default-bright">
					<div class="card-body small-padding">
						<img class="img-circle img-responsive pull-left width-1" src="http://www.codecovers.eu/assets/img/modules/materialadmin/avatar9.jpg?1422538626" alt="">
						<span class="text-medium">Received a <a class="text-primary" href="http://www.codecovers.eu/materialadmin/mail/inbox">message</a> from <span class="text-primary">Ann Lauren</span></span><br>
						<span class="opacity-50">
							Saturday, Oktober 18, 2014
						</span>
					</div><!--end .card-body -->
				</div><!--end .card -->
			</div><!--end .timeline-entry -->
		</li>		
		*/

		$('<li>').addClass('timeline-inverted')
			.append( $('<div>').addClass('timeline-circ').addClass('circ-xl').addClass('style-'+bs_color)
				.append(
					$('<i>').addClass('fa').addClass(message.icon).html(' ')
				)
			)
			.append( $('<div>').addClass('timeline-entry')
				.append( $('<div>').addClass('card').addClass('style-default-bright')
					.append( $('<div>').addClass('card-body').addClass('small-padding')
						.append(
							$('<span>').addClass('message-header')
								.append( $('<span>').addClass('time').addClass('opacity-50')
									.append(
										$('<i>').addClass('fa').addClass('fa-clock-o')
									).append(moment(new Date()).format('ddd D MMM YY H:mm'))
								)
								.append( $('<span>').addClass('title').html(title) )
						)
						.append(
							$('<span>').addClass('message-body').addClass('wire-more').addClass('text-medium').html('<br/>' + text + '<br/>')
						)
						.append(
							$('<span>').addClass('message-footer')
							.append(tagPills)
							.append(
								$('<span>').addClass('label').addClass('label-info').html('Published on '+moment(message.created_at).format('ddd D MMM YY H:mm'))
							)
						)
					)
				)
			)
		.addClass('wire-message')
		.attr('data-item-tags', tags.join(','))
		.attr('id', 'wire-message-'+message.id)
		.prependTo("#"+opts.id).hide().slideDown(opts.speed);

		// increase alert count indicator
		$('#gip-alerts').html(parseInt($('#gip-alerts').html()) + 1);

		// Cleanup

		// Rebuild task list, sort it, and set those that were active.
		// 1. remember which ones where selected
		var tagsortActive = $('div.tagsort-tags-container span.tagsort-active');
		// 2. rebuild list
		$('div.tagsort-tags-container').html('').tagSort({
			items:'.wire-message'
		}).find('span').sortElements(function(a, b){
		    return $(a).text() > $(b).text() ? 1 : -1;
		});
		// 3. select those which were selected
		var hasTags = 0;
		if(tagsortActive.length !== 0) {
			tagsortActive.each(function() {
				tag = $(this).html();
				if(opts.filterNewMessage && (tags.indexOf(tag) > -1)) { // current message has tag
					hasTags++;
				}
				$('div.tagsort-tags-container span:contains("'+tag+'")').addClass('tagsort-active');
			});
		}
		if(opts.filterNewMessage && tagsortActive.length !== hasTags) {
			$('li#wire-message-'+message.id).toggle(false);
		}

		$(".wire-more-link").click(function(){
			if($(this).hasClass("wire-less")) {
				$(this).removeClass("wire-less");
				$(this).html(opts.moretext);
			} else {
				$(this).addClass("wire-less");
				$(this).html(opts.lesstext);
			}
			$(this).parent().prev().toggle();
			$(this).prev().toggle();
			return false;
		});

	};

	// Extend JQuery for $.wireWidget().addWire()
	// ONLY prototype(static) methods
	$.extend({
		wireWidget: WireWidget.prototype
	});

})(jQuery);