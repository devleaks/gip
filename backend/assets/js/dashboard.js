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
		max_priority: 5,
		replay_live: 10000,
		begin_delimiter: '{{',
		end_delimiter: '}}',
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
	
	Dashboard.prototype.set_replay_speed = function(speed) {
		return _replay_speed = speed;
	};
	
	Dashboard.prototype.get_time = function() {
		return _replay_time;
	};
	
	Dashboard.prototype.get_debug = function() {
		return opts.debug;
	};
	
	Dashboard.prototype.tick = function() {
		return _replay_time.setSeconds(_replay_time.getSeconds() + _replay_speed);
	};
	
	Dashboard.prototype.big_tick = function() {
		return _replay_time.setSeconds(_replay_time.getSeconds() + 600);
	};
	
	Dashboard.prototype.live = function() {
		var now = new Date();
		return Math.abs(_replay_time.getTime() - now.getTime()) < defaults.replay_live;
	};
	
	Dashboard.prototype.get_payload = function (msg) {
		try { // may be payload was already parsed in normalize()
			var ret = JSON.parse(msg.payload);
			return ret; // replace JSON version with object
		} catch(e) {
			return msg.payload;
		}
		// return JSON.parse(msg.payload); // now payload can only be in payload attribute.
		/* If payload can either be in body or payload, use following code:
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
		*/
	}


	Dashboard.prototype.last_updated = function (msg, elem) {
		var now = new Date();

		var addZero = function (i) {
		    if (i < 10) {
		        i = "0" + i;
		    }
		    return i;
		}
		
		if(opts.debug) {
			console.log('Dashboard.prototype.last_updated: updated at '+now);
		}
		elem.find('.gip-footer').html('LAST UPDATED ' + addZero(now.getHours()) + ':' + addZero(now.getMinutes()) + ' L');
	}

	function get_giplet_id(msg) {
		var id = msg.source.toLowerCase()+'-'+msg.type.toLowerCase();
		if(typeof msg.channel !== undefined) {
			if((msg.channel !== null) && (msg.channel!= '')) {
				id += ('-'+msg.channel);
			}
		}
		if(opts.debug) {
			console.log(id);
		}
		// id.replace(/^[^a-z]+|[^\w:.-]+/gi, "");
		return '#gip-' + id.replace(/^[^a-z]+|[^\w:.-]+/gi, "");
	}
	
	function substitute_text(msg, text) {
		return Mustache.render(text, msg);
	}

	function substitute_text2(msg, text) {
		var search = opts.begin_delimiter+'([^}]+)'+opts.end_delimiter;
		var regexp = new RegExp(search, 'g');
		var match;
		var newtext = text;
		//console.log('Dashboard::substitute: original: '+text,search,regexp,text.match(regexp));

		while ((match = regexp.exec(text)) != null) {
		    // matched text: match[0]
		    // match start: match.index
		    // capturing group n: match[n]
			var varname = match[1];
			console.log('Dashboard::varname: '+varname);
			try {
				var value = JSPath.apply(varname, msg);
				console.log(varname+"="+value);
				if(value != null) {
					newtext = newtext.replace(new RegExp(opts.begin_delimiter+varname+opts.end_delimiter, 'g'), value);
				}				
			} catch (e) {
				console.log('JSPath failed for '+varname, msg, e);			
			}
		}
				
		//console.log('Dashboard::substitute_text: substitued: '+newtext);
		return newtext;
	}

	function substitute(msg) { // both title and subject are searched for substitution
		if(msg.payload === null)
			return;
		// subject
		msg.subject_template = msg.subject;
		msg.subject = substitute_text(msg, msg.subject);
		// body
		msg.body_template = msg.body;
		msg.body = substitute_text(msg, msg.body);;
	}

	function send_to_wire(msg) {
		if(msg.priority > 0) {
			substitute(msg);
			$('#'+opts.id).trigger('gip:message', msg);
			$('#'+opts.id+' ul').scrollTop($('#'+opts.id+' ul')[0].scrollHeight);
		}
	}
	
	function normalize(msg) {
		// ensure priority 0 < p < 
		var priority = parseInt(msg.priority);
		if(isNaN(priority)) priority = 0;
		if(priority > opts.max_priority) priority = opts.max_priority;
		msg.priority = priority;

		//build giplet id
		msg.target_id = get_giplet_id(msg);

		//check if payload exists, and parses it
		if(msg.payload == null || msg.payload == '') {
			if(opts.debug) { 
				console.log('Dashboard::normalize: no payload');
			}
			msg.payload = null;
		} else {
			msg.payload_orig = msg.payload; // keep original payload here
			try {
				var ret = JSON.parse(msg.payload);
				msg.payload = ret; // replace JSON version with object
			} catch(e) {
				msg.payload = null;
				console.log('Dashboard::normalize: cannot decode payload');
				console.log(e);
			}
		}
	}
	
	Dashboard.prototype.broadcast = function (msg) {
		normalize(msg);
		//1. send message to giplet unless it is directed to the wire
		if(msg.source.toLowerCase() != 'gip' || msg.type.toLowerCase() != 'wire') {
			$(msg.target_id).trigger('gip:message', msg);
		}

		//2. display message on wire if priority>0.
		//messages with priority < 1 are not displayed on the wire (but the recipient giplet still gets the message from step 1 above)
		send_to_wire(msg);
	}

	
	
	// Init & start ws connection
    function wsStart() {
		var ws = new WebSocket(opts.websocket);
        ws.onopen = function() { opts.intro_messages.opening.created_at = new Date(); send_to_wire(opts.intro_messages.opening); };
        ws.onclose = function() { if(opts.debug) { opts.intro_messages.closing.created_at = new Date(); send_to_wire(opts.intro_messages.closing); } };
        ws.onmessage = function(evt) {
			var ret = null;
			try {
				ret = $.parseJSON(evt.data);
			} catch(e) {
				console.log('Dashboard::wsStart: cannot decode message');
				console.log(e);
				ret = opts.error;
				ret.body = 'Dashboard::wsStart: cannot decode message';
			}
			Dashboard.prototype.broadcast(ret);
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