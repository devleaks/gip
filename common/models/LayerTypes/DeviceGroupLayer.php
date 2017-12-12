<?php

namespace common\models\LayerTypes;

use Yii;

/**∑
 * This is the model class for table "layer_type".
 */
class DeviceGroupLayer extends GipLayer
{
	
	public function init() {
		$this->group_type = self::TYPE_DEVICE;
		$this->groupModel = 'common\models\DeviceGroup';
		$this->modelName = 'common\models\Device';
		$this->layerModel = 'common\models\leaflet\DeviceGroup';
		parent::init();
	}

}
