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
		clock_id: "gip-gip-clock",
		// Websocket feeds
		websocket: null,
		initSeed: null,	//gipadmin/wire/seed
		markRead: null,	//gipadmin/wire/read
		moreOlder: null,	//gipadmin/wire/older
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
			},
			error: {
				subject: 'Dashboard Error',
				body: 'Error message',
				priority: 1,
				source: 'dashboard',
				type: 'error',
				icon: 'fa-danger',
				color: '#f00'
			}
		}
	};
	var _replay_time = new Date();
	var _replay_speed = 1;

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
		if(opts.websocket !== null) {
	    	wsStart();
		}
		if(opts.initSeed!== null) {
			initSeed();
		}
	};
	
	Dashboard.prototype.set_time = function(replay_time) {
		if(replay_time === null) {
			_replay_time = new Date();
		} else {
			_replay_time = replay_time;
		}
		$("#"+opts.clock_id).trigger('gip:change');
	};
	
	Dashboard.prototype.get_time = function() {
		return _replay_time;
	};
	
	Dashboard.prototype.tick = function() {
		return _replay_time.setSeconds(_replay_time.getSeconds() + _replay_speed);
	};
	
	Dashboard.prototype.live = function() {
		var now = new Date();
		return Math.abs(_replay_time.getTime() - now.getTime()) < 2000;
	};
	
	Dashboard.prototype.get_payload = function (msg) {
		if(opts.debug) {
			console.log({code: 'Dashboard.prototype.get_payload', message: msg});
		}
		var ret = null;
		var fnd = 'nothing';
		try {
			ret = JSON.parse(msg.body);
			fnd = 'body';
		} catch(e) {
			if(opts.debug) {
				console.log('Dashboard.prototype.get_payload: cannot decode body');
				console.log(e);
			}
			try {
				ret = JSON.parse(msg.payload);
				fnd = 'payload';
			} catch(e) {
				if(opts.debug) {
					console.log('Dashboard.prototype.get_payload: cannot decode payload');
					console.log(e);
				}
				return false;
			}
		}
		if(opts.debug) {
			console.log('Dashboard.prototype.get_payload: found payload in '+fnd);
		}
		return ret;
	}


	Dashboard.prototype.last_updated = function (msg, elem) {
		var now = new Date();
		if(opts.debug) {
			console.log('Dashboard.prototype.last_updated: updated at '+now);
		}
		elem.find('.gip-footer').html('LAST UPDATED ' + now.getHours() + ':' + now.getMinutes() + ' L');
	}

	
	
	function makeSafeForCSS(name) {
	    return name.replace(/[^a-z0-9]/g, function(s) {
	        var c = s.charCodeAt(0);
	        if (c == 32 || c == 45) return '-';
	        if (c >= 65 && c <= 90) return '_' + s.toLowerCase();
	        return '__' + ('000' + c.toString(16)).slice(-4);
	    });
	}
	
	function get_giplet_id(msg) {
		var id = '#gip-' + makeSafeForCSS(msg.source.toLowerCase()+'-'+msg.type.toLowerCase());
		if(typeof msg.channel !== undefined) {
			if(msg.channel !== null) {
				id += ('-'+msg.channel);
			}
		}
		console.log(id);
		return id;
	}
	
	function send_to_wire(msg) {
		if(msg.priority > 0) {
			$('#'+opts.id).trigger('gip:message', msg);
			$('#'+opts.id+' ul').scrollTop($('#'+opts.id+' ul')[0].scrollHeight);
		}
	}
	
	Dashboard.prototype.broadcast = function (msg) {
		var priority = parseInt(msg.priority);
		if(isNaN(priority)) priority = 0;
		if(priority > 5) priority = 5;
		msg.priority = priority;
		//build giplet id
		var gid = get_giplet_id(msg);
		//send message to giplet
		$(gid).trigger('gip:message', msg);
		//display message on wire if priority>0.
		//messages with priority < 1 are not displayed on the wire (but the recipient giplet gets the message)
		send_to_wire(msg);
	}

	
	Dashboard.prototype.substitute = function (msg) {
		var text = msg.body;
		var occurences = text.match(/{{(.)+}}/gi);
		console.log(occurences);
		
	}

	
	// Init & start ws connection
    function wsStart() {
		var ws = new WebSocket(opts.websocket);
        ws.onopen = function() { opts.intro_messages.opening.created_at = new Date(); send_to_wire(opts.intro_messages.opening); };
        ws.onclose = function() { if(opts.debug) { opts.intro_messages.closing.created_at = new Date(); send_to_wire(opts.intro_messages.closing); } };
        ws.onmessage = function(evt) {
			try {
				var msg = $.parseJSON(evt.data);
				Dashboard.prototype.broadcast(msg);
			} catch(e) {
				console.log('Dashboard::wsStart: cannot decode message');
				console.log(e);
				opts.error.body = 'Dashboard::wsStart: cannot decode message';
				Dashboard.prototype.broadcast(opts.error);
			}
		};
    }

	// Fetches last messages (if url provided). Displays them all.
	function initSeed() {
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


	// Extend JQuery for $.dashboard().addWire()
	// ONLY prototype(static) methods
	$.extend({
		dashboard: Dashboard.prototype
	});

})(jQuery);