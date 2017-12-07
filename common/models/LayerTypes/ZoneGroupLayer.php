<?php

namespace common\models\LayerTypes;

use Yii;

/**
 * This is the model class for table "layer_type".
 */
class ZoneGroupLayer extends GipLayer
{
	
	public function init() {
		$this->group_type = self::TYPE_ZONE;
		$this->groupModel = 'common\models\ZoneGroup';
		$this->layerModel = 'common\models\leaflet\ZoneGroup';
		parent::init();
	}

}
