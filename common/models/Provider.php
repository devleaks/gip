<?php

namespace common\models;

use common\behaviors\AttributeValueTrait;

use Yii;
use \common\models\base\Provider as BaseProvider;

/**
 * This is the model class for table "provider".
 */
class Provider extends BaseProvider
{
	use AttributeValueTrait;
	
	public function getType() {
		return 'common\\models\\ProviderType';
	}
}
