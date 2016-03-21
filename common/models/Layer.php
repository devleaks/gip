<?php

namespace common\models;

use common\behaviors\AttributeValue;
use common\behaviors\Constant;

use Yii;
use \common\models\base\Layer as BaseLayer;

/**
 * This is the model class for table "layer".
 */
class Layer extends BaseLayer
{
	use AttributeValue;
	use Constant;

	const STATUS_ENABLED = 'ENABLED';
	const STATUS_DISABLED = 'DISABLED';
	

	public function getType() {
		return $this->layerType;
	}
}
