/**
 *	jQuery Cometdash Plugin
 *
 *	jQuery plugin to send pubsub events to Dashboard GIPlets.
 *
 *  NOTES
 *
 *  1. Requires jQuery
 *
 *	2. pubsubEvent.data expects the following structure (JSON encoded):

var Message = {
	subject: "Metar 24 at 13:30Z",	/* string * /
	body: "EBBR 241320Z 04004KT 340V130 9999 FEW042 20/09 Q1016 NOSIG",	/* string * /
	link: "http://weather.noaa.gov/pub/data/observations/metar/stations/EBBR.TXT",	/* string * /
	source: "NOAA",		/* string * /
	type: "metar",		/* string * /
	priority: 2,		/* number * /
	color: "info",		/* string * /
	icon: "fa-info",	/* string * /
	timestamp: "20160624143258.635Z",	/* string ISO 8601 coded * /
	status: "active"	/* string * /
}

 *
 *	Rev. 1.0 08-JUN-2016
 *
 *	USAGE
 *
 *	1. Initialisation
 *

jQuery(document).ready(function($){

	$.dashboard.init({id: "gip-gip-wire"});

});

 *
 *	2. Use
 *

jQuery(document).ready(function($){

	$.dashboard.send(pubsubEvent);

});

 *
 *  3. Example (for testing purpose, this is sufficient)
 *

jQuery(document).ready(function($){

	$.dashboard.send(
		{
			data: {
				subject: "Metar 24 at 13:30Z",	
				body: "EBBR 241320Z 04004KT 340V130 9999 FEW042 20/09 Q1016 NOSIG",	
				link: "http://weather.noaa.gov/pub/data/observations/metar/stations/EBBR.TXT",	
				source: "NOAA",		
				type: "metar",		
				priority: 2,
				color: "info",		
				icon: "fa-info",	
				timestamp: "20160624143258.635Z",	/* string ISO 8601 coded * /
				status: "active"	
			}
		}
	);
	
	$.dashboard.test();

});

 *
 **/
 
(function($) {
	"use strict";

	/*
	 * Default Values
	 */
	var opts;
	var defaults = {
		debug: false,
		id: "gip-gip-wire",
		jqe_type: 'gip:message'
	};

	/*
	 * Only gets called when we're using $('$el').dashboard format
	 */
	var Cometdash = function() {
		
	}
	
	/**
	 *	Initialisation with default values
	 **/
	Cometdash.prototype.init = function(options) {
		opts = $.extend( {}, defaults, options);
		if(opts.debug) {
			opts.intro_messages.starting.created_at = new Date(); 
			send_to_wire(opts.intro_messages.starting);
		}
	};
	
	/**
	 *	Build giplet html element id from message meta data
	 *
	 *	@param msg Message object
	 **/
	function get_giplet_id(msg) {
		var id = '#gip-'+msg.source.toLowerCase()+'-'+msg.type.toLowerCase();
		if(typeof msg.channel !== undefined) {
			if(msg.channel !== null) {
				id += ('-'+msg.channel);
			}
		}
		return id;
	}
	
	/**
	 *	Send message to wire for display.
	 *	Message is only sent to display if it has a priority > 0.
	 *	This allow to send message to giplet without displaying them on the wire.
	 *
	 *	@param msg Message object
	 **/
	function send_to_wire(msg) {
		if(msg.priority > 0) {
			$('#'+opts.id).trigger(opts.jqe_type, msg);
			$('#'+opts.id+' ul').scrollTop($('#'+opts.id+' ul')[0].scrollHeight);
		}
	}
	
	/**
	 *	Main routine. Send event to appropriate GIPlet
	 **/
	Dashboard.prototype.send = function(pubsubEvent) {
		//c'est jamais mauvais de voir ce qui se passe...
		if(showWire_debug) {
	    	console.log(pubsubEvent);
		}

		var msg = $.parseJSON(pubsubEvent.data);
		//fix priority because it is used in js at numerous place. Must be 0 <= priority <= 5.
		var priority = msg.priority == null ? 0 : parseInt(msg.priority);
		msg.priority = (priority > 5) ? 5 : priority;
		//build giplet id
		var gid = get_giplet_id(msg);
		//send message to giplet
		$(gid).trigger(jqe_type, msg);
		//send message for display on wire
		send_to_wire(msg);
	}
	
	/**
	 *	Test routine. Send event to wire. Display status on browser console (always).
	 **/
	Dashboard.prototype.test = function() {
		var test_event = {data: {
			subject: "Metar 24 at 13:30Z",	
			body: "EBBR 241320Z 04004KT 340V130 9999 FEW042 20/09 Q1016 NOSIG",	
			link: "http://weather.noaa.gov/pub/data/observations/metar/stations/EBBR.TXT",	
			source: "gip",		
			type: "test",		
			priority: 2,
			color: "info",		
			icon: "fa-info",	
			timestamp: "20160624143258.635Z",
			status: "active"	
		}};
		console.log('sending test event to wire...');
		console.log(test_event);		
		Dashboard.prototype.send(test_event);
		console.log('sent!');
	}
	/**
	 *	Installation of plugin
	 *	Extend JQuery for $.dashboard().addWire()
	 *	ONLY prototype(static) methods
	 **/
	$.extend({
		dashboard: Cometdash.prototype
	});

})(jQuery);