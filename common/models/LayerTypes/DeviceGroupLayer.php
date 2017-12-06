<?php

namespace common\models\LayerTypes;

use common\models\DeviceGroup as DeviceGroupModel;
use common\models\leaflet\DeviceGroup;
use dosamigos\leaflet\layers\GeoJson;

use Yii;

/**
 * This is the model class for table "layer_type".
 */
class DeviceGroupLayer extends Layer
{

	public function getRepresentation() {
		$parameters = $this->layer->getAttributeValues();
		
		$gname = $parameters['DEVICE_GROUP'];
		$g = DeviceGroupModel::findOne(['display_name' => $gname]);
		$e  = $g->export();

		Yii::trace(json_encode($e, JSON_PRETTY_PRINT), 'DeviceGroupLayer::getRepresentation');
		
		return new DeviceGroup(['data' => $e]);
	}
	
}
