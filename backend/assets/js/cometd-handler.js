/**
 *	showWire
 *
 *	@param  pubsubEvent Pubsub Event
 *
 *  @return nothing
 *
 *  Notes
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
 **/

function showWire(pubsubEvent) {
	/** Send payload to browser console */
	var showWire_debug = true;
	/** DOM element identifier for wire */
	var wire_id = "gip-gip-wire";
	/** jQuery event type sent to GIPlets */
	var jqe_type = 'gip:message';

	/**
	 *	Build giplet html element id from message meta data
	 *
	 *	@param msg Message object
	 **/
	function get_giplet_id(msg) {
		var giplet_id = '#gip-'+msg.source+'-'+msg.type;
		if(typeof msg.channel !== undefined) {
			if(msg.channel !== null) {
				giplet_id += ('-'+msg.channel);
			}
		}
		return giplet_id.toLowerCase();
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
			$('#'+wire_id).trigger(jqe_type, msg);
			$('#'+wire_id+' ul').scrollTop($('#'+wire_id+' ul')[0].scrollHeight);
		}
	}
	
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
