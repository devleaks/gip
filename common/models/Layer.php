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
	
}
