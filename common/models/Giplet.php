<?php

namespace common\models;

use common\behaviors\AttributeValue;
use common\behaviors\Constant;

use Yii;
use \common\models\base\Giplet as BaseGiplet;

/**
 * This is the model class for table "giplet".
 */
class Giplet extends BaseGiplet
{
	use AttributeValue;
	use Constant;

	const STATUS_ENABLED = 'ENABLED';
	const STATUS_DISABLED = 'DISABLED';
	

	public function getType() {
		return $this->gipletType;
	}
}
