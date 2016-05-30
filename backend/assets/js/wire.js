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
jQuery.fn.sortElements = (function(){

    var sort = [].sort;

    return function(comparator, getSortable) {

        getSortable = getSortable || function(){return this;};

        var placements = this.map(function(){

            var sortElement = getSortable.call(this),
                parentNode = sortElement.parentNode,

                // Since the element itself will change position, we have
                // to have some way of storing its original position in
                // the DOM. The easiest way is to have a 'flag' node:
                nextSibling = parentNode.insertBefore(
                    document.createTextNode(''),
                    sortElement.nextSibling
                );

            return function() {

                if (parentNode === this) {
                    throw new Error(
                        "You can't sort elements if any one is a descendant of another."
                    );
                }

                // Insert before flag:
                parentNode.insertBefore(this, nextSibling);
                // Remove flag:
                parentNode.removeChild(nextSibling);

            };

        });

        return sort.call(this, comparator).each(function(i){
            placements[i].call(getSortable.call(this));
        });

    };

})();


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
		dateReminder: 120, // minutes
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
		}
	};

	// Timestamp of last addition. Used to make date markers.
	var lastDateReminder = null;
	
	// Main subroutine
	function addWire(message) {
		var tags = new Array();
		var addTags = function(str) {
			if(defaults.ignoreTags.indexOf(str) == -1)
				tags.push(str);
		}
		
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
		addTags('p'+priority);
		addTags(message.source);
		addTags(message.type);


		// Color
		if(message.color.substr(0, 1) != '#' && $.inArray(message.color, defaults.priority_map)) { // uses bootstrap color
			//console.log('uses bs color');
			message.color = defaults.color;
		}
		
		// Icon
		
				
		// Link
		var title = message.subject;
		if(message.link) {
			title = $('a').attr('href', message.link);
		}

		// Body
		var text = message.body;
		
		// special message parsing
		if(message.type.toLowerCase() == 'metar') {
			metar = metar_decode(text);
			if(metar.length > 0) {
				text = metar.replace(/(?:\r\n|\r|\n)/g, '<br />') + '<br/><pre>'+text+'</pre>';
			}
		}
		// text shortening
		if(defaults.numWords > 0) {
			var content = text.split(" ");
			if(content.length > defaults.numWords) {
				text = content.slice(0,defaults.numWords).join(" ")
						 + '&nbsp;<span class="wire-more-elipses">' + defaults.ellipsestext
						 + '</span>&nbsp;<span class="wire-more-content"><span>'
						 + content.slice(defaults.numWords,content.length).join(" ")
						 + '</span>&nbsp;&nbsp;<a href="" class="wire-more-link">'
						 + defaults.moretext + '</a></span>';
			}
		}
		
		// Do we need a new Date reminder in the margin?
		if(lastDateReminder == null || ((Date() - lastDateReminder) > (defaults.dateReminder * 3600000)) ) {
			$('<li>').addClass('time-label')
					.append($('<span>').addClass('bg-blue').html(moment().format("ddd D MMM H:m")))
					.prependTo("#"+defaults.id);
			lastDateReminder = new Date();
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
			.append( $('<div>').addClass('timeline-body').addClass('wire-more').html(defaults.debug ? text + '<br/>' + JSON.stringify(message) : text) )
			.append( $('<div>').addClass('timeline-footer')
				.append(
					$('<a>').addClass('btn').addClass('btn-'+bs_color).addClass('btn-xs').html('Published on '+moment(message.created_at).format('ddd D MMM YY H:mm'))
				)
			)
		)
		.addClass('wire-message')
		.attr('data-item-tags', tags.join(',').toLowerCase())
		.attr('id', 'wire-message-'+message.id)
		.prependTo("#"+defaults.id).hide().slideDown(defaults.speed);
		
		// Cleanup

		// Rebuild task list, sort it, and set those that were active.
		// 1. remember which ones where selected
		tagsortActive = $('div.tagsort-tags-container span.tagsort-active');
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
				if(defaults.filterNewMessage && (tags.indexOf(tag) > -1)) { // current message has tag
					hasTags++;
				}
				$('div.tagsort-tags-container span:contains("'+tag+'")').addClass('tagsort-active');
			});
		}
		if(defaults.filterNewMessage && tagsortActive.length !== hasTags) {
			$('li#wire-message-'+message.id).toggle(false);
		}
		
		$(".wire-more-link").click(function(){
			if($(this).hasClass("wire-less")) {
				$(this).removeClass("wire-less");
				$(this).html(defaults.moretext);
			} else {
				$(this).addClass("wire-less");
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
	$('.wire-more').each(function() {
		var content = $(this).html().split(" ");
		if(content.length > defaults.numWords) {
			var c = content.slice(0,defaults.numWords).join(" ");
			var h = content.slice(defaults.numWords,content.length).join(" ");
			var html = c + '&nbsp;<span class="wire-more-elipses">' + defaults.ellipsestext
						 + '</span>&nbsp;<span class="wire-more-content"><span>'
						 + h + '</span>&nbsp;&nbsp;<a href="" class="wire-more-link">'
						 + defaults.moretext + '</a></span>';
			$(this).html(html);
		}
	});
	
	$(".wire-more-link").click(function(){
		if($(this).hasClass("wire-less")) {
			$(this).removeClass("wire-less");
			$(this).html(defaults.moretext);
		} else {
			$(this).addClass("wire-less");
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
			$('#'+defaults.id).scrollTop($('#'+defaults.id)[0].scrollHeight);
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