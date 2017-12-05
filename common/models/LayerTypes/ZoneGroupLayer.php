<?php

namespace common\models\LayerTypes;

use common\models\leaflet\ZoneGroup;
use dosamigos\leaflet\layers\GeoJson;

use Yii;

/**
 * This is the model class for table "layer_type".
 */
class ZoneGroupLayer extends Layer
{

	public function getRepresentation() {
		return new GeoJson([
			'data' => [
				"type" => "MultiPoint",
				"coordinates" => [[50.62250,5.41630], [50.65655,5.47567]]
			]
		]);
	}
	
}
