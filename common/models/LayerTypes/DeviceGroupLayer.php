<?php

namespace common\models\LayerTypes;

use common\models\leaflet\DeviceGroup;
use dosamigos\leaflet\layers\GeoJson;

use Yii;

/**
 * This is the model class for table "layer_type".
 */
class DeviceGroupLayer extends Layer
{

	public function getRepresentation() {
		return new GeoJson([
			'data' => [
			        "type" => "Point",
			        "coordinates" => [
			           5.45987,
			          50.6435
			        ]
			]
		]);
	}
	
}
