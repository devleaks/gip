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
		id: "the-wire",
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
			Dashboard.prototype.addWire(opts.intro_messages.starting);
		}
		install();
	    wsStart();
		initSeed();
	};
	
	function get_giplet_id(msg) {
		id = '#gip-'+msg.source.toLowerCase()+'-'+msg.type.toLowerCase();
		if(typeof msg.channel !== undefined)
			id += '-'.msg.channel.toLowerCase;
		return id;
	}
	
	// Init & start ws connection
    function wsStart() {
		var ws = new WebSocket(opts.websocket);
        ws.onopen = function() { opts.intro_messages.opening.created_at = new Date(); Dashboard.prototype.addWire(opts.intro_messages.opening); };
        ws.onclose = function() { if(opts.debug) { opts.intro_messages.closing.created_at = new Date(); Dashboard.prototype.addWire(opts.intro_messages.closing); } };
        ws.onmessage = function(evt) {
			var msg = $.parseJSON(evt.data);
			var gid = get_giplet_id(msg);
			console.log("notifying " + gid + "...");
			$(gid).trigger('gip:message', msg);
			console.log("..." + gid + " notified");
			var priority = msg.priority == null ? 0 : parseInt(msg.priority);
			if(priority >= 0) {
				console.log("sending to wire " + gid);
				$('#'+opts.id).trigger('gip:message', msg);
				$('#'+opts.id).scrollTop($('#'+opts.id)[0].scrollHeight);
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
						Dashboard.prototype.addWire(msgs[idx]);
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