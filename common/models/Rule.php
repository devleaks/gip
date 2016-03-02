<?php

namespace common\models;

use common\behaviors\AttributeValue;

use Yii;
use \common\models\base\Rule as BaseRule;

/**
 * This is the model class for table "rule".
 */
class Rule extends BaseRule
{
	use AttributeValue;
	
	public function getType() {
		return $this->detectionType;
	}
}
