<?php

namespace common\models\LayerTypes;

use dosamigos\leaflet\layers\TileLayer;

use Yii;

/**
 * This is the model class for table "layer_type".
 */
class TileLayer extends Layer
{

	public function getRepresentation() {
		$parameters = $this->layer->getAttributeValues();
		
		$clientOptions = [];
		if($parameters['JSON_PARAMETER']) { // params are in format name=value,name=value
			foreach(explode(',', $parameters['JSON_PARAMETER']) as $nv) {
				$d = explode(':', str_replace("'", "", str_replace('"', '', $nv)));
				$clientOptions[$d[0]] = $d[1];
			}
		}
		
		return new TileLayer([
			'urlTemplate' => $parameters['URL'],
		    'clientOptions' => $clientOptions,
		]);
	}
	
}
