<?php

namespace common\models\LayerTypes;

use Yii;

use dosamigos\leaflet\types\LatLng;
use dosamigos\leaflet\types\LatLngBounds;
use dosamigos\leaflet\layers\ImageOverlay;

/**
 * This is the model class for table "layer_type".
 */
class ImageOverlay extends Layer
{

	public function getRepresentation() {
		$parameters = $this->layer->getAttributeValues();

		return new ImageOverlay([
			'imageBounds' => new LatLngBounds(['southWest' => new LatLng(['lat'=>50.62250,'lng'=>5.41630]), 'northEast'=> new LatLng(['lat'=>50.65655,'lng'=>5.47567])]),
			'imageUrl' => $parameters['URL'],
			'clientOptions' => ['opacity' => 0.8]
		]);
	}
	
}
