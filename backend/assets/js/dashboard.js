/*
 * jQuery Dashboard Widget Helper
 * 2016 Pierre M
 * License: MIT
 */
 
(function($) {
	"use strict";

	/*
	 * Default Values
	 */
	var opts;
	var defaults = {
		debug: false,
		id: "gip-gip-wire",
		// Websocket feeds
		websocket: 'ws://localhost:8051/',
		initSeed: '',///gipadmin/wire/seed
		markRead: '/gipadmin/wire/read',
		moreOlder: '',///gipadmin/wire/older
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

	/*
	 * Only gets called when we're using $('$el').dashboard format
	 */
	var Dashboard = function() {
		
	}
	
	Dashboard.prototype.init = function(options) {
		opts = $.extend( {}, defaults, options);
		if(opts.debug) {
			opts.intro_messages.starting.created_at = new Date(); 
			send_to_wire(opts.intro_messages.starting);
		}
		// install();
	    wsStart();
		initSeed();
	};
	
	function get_giplet_id(msg) {
		var id = '#gip-'+msg.source.toLowerCase()+'-'+msg.type.toLowerCase();
		if(typeof msg.channel !== undefined) {
			if(msg.channel !== null) {
				id += ('-'+msg.channel);
			}
		}
		return id;
	}
	
	function send_to_wire(msg) {
		if(msg.priority > 0) {
			$('#'+opts.id).trigger('gip:message', msg);
			$('#'+opts.id+' ul').scrollTop($('#'+opts.id+' ul')[0].scrollHeight);
		}
	}
	
	// Init & start ws connection
    function wsStart() {
		var ws = new WebSocket(opts.websocket);
        ws.onopen = function() { opts.intro_messages.opening.created_at = new Date(); send_to_wire(opts.intro_messages.opening); };
        ws.onclose = function() { if(opts.debug) { opts.intro_messages.closing.created_at = new Date(); send_to_wire(opts.intro_messages.closing); } };
        ws.onmessage = function(evt) {
			var msg = $.parseJSON(evt.data);
			//fix priority because it is used in js at numerous place. Must be 0 <= priority <= 5.
			var priority = msg.priority == null ? 0 : parseInt(msg.priority);
			msg.priority = (priority > 5) ? 5 : priority;
			//build giplet id
			var gid = get_giplet_id(msg);
			//send message to giplet
			$(gid).trigger('gip:message', msg);
			//display message on wire if priority>0.
			//messages with priority < 1 are not displayed on the wire (but the recipient giplet gets the message)
			send_to_wire(msg);
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
						send_to_wire(msgs[idx]);
					}
	            }
			);

		}
	}


	// Extend JQuery for $.dashboard().addWire()
	// ONLY prototype(static) methods
	$.extend({
		dashboard: Dashboard.prototype
	});

})(jQuery);