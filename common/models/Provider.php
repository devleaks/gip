<?php

namespace common\models;

use common\behaviors\AttributeValue;

use Yii;
use \common\models\base\Provider as BaseProvider;

/**
 * This is the model class for table "provider".
 */
class Provider extends Channel
{
	use \common\behaviors\ListAll;
	use AttributeValue;

	const DIRECTION = ChannelType::DIRECTION_IN;	
	
}
