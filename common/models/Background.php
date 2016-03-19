<?php

namespace common\models;

use common\behaviors\AttributeValue;

use Yii;
use \common\models\base\Background as BaseBackground;

/**
 * This is the model class for table "background".
 */
class Background extends BaseBackground
{
	use AttributeValue;

	public function getType() {
		return $this->backgroundType;
	}
}
