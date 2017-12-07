<?php

namespace common\models;

use common\behaviors\AttributeValue as AttributeValueBehavior;
use common\behaviors\Constant;

use Yii;
use \common\models\base\Layer as BaseLayer;

/**
 * This is the model class for table "layer".
 */
class Layer extends BaseLayer
{
	use AttributeValueBehavior;
	use Constant;

	const STATUS_ENABLED = 'ENABLED';
	const STATUS_DISABLED = 'DISABLED';
	
	/* key words */
	const TYPE_BASE = 'base';
	const TYPE_OVERLAY = 'overlay';
	

	public function getType() {
		return $this->layerType;
	}
	
	public function getFactory() {
		return new $this->type->factory(['layer' => $this]);
	}
/* See: https://oscars.atlassian.net/wiki/spaces/gip/pages/63779741/GIP+Layer

"_style": {
    "markerColor": "rgb(0,255,0)",
    "weight": 1,
    "opacity": 0.8,
	"fillColor": "rgb(0,255,0)",
    "fillOpacity": 0.4,
	"markerSymbol": 'plane',
	"markerRotationOffset": -45
},
"_templates": {
	formatDate: function() {
	    return function(text, render) {
	    	return Date( parseInt(render(text)) * 1000);
		}
	},
	"show_label": true,
	"tooltip":	"{{feature.properties.display_name}}",
	"popup":		"{{feature.properties.display_name}} is {{feature.properties.display_status}} / {{feature.properties.status}}",
	"sidebar":	"{{feature.properties.display_name}} is {{feature.properties.display_status}} / {{feature.properties.status}}.<br/>"
				+"Last seen at formated date: {{#templates.formatDate}}"
				+"{{feature.properties._timestamp}}"
				+"{{/templates.formatDate}}.<br/>"
				+"Available {{&texts.linkURL}}."
				,
	"linkText":	"Link to {{feature.properties.display_name}}",
	"linkURL":	"<a href='#path-to-get-more-details?id={{feature.properties.name}}'>{{texts.linkText}}</a>"	// !
}
*/	
}
