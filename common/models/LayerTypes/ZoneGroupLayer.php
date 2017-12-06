<?php

namespace common\models\LayerTypes;

use common\models\ZoneGroup as ZoneGroupModel;
use common\models\leaflet\ZoneGroup;
use dosamigos\leaflet\layers\GeoJson;

use Yii;

/**
 * This is the model class for table "layer_type".
 */
class ZoneGroupLayer extends Layer
{

	public function getRepresentation() {
		$parameters = $this->layer->getAttributeValues();
		
		$gname = $parameters['ZONE_GROUP'];
		$g = ZoneGroupModel::findOne(['display_name' => $gname]);
		$e  = $g->export();

		//Yii::trace(json_encode($e, JSON_PRETTY_PRINT), 'ZoneGroupLayer::getRepresentation');
		
		return new ZoneGroup(['data' => $e]);
	}
	
}
