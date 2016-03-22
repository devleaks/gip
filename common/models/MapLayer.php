<?php

namespace common\models;

use common\behaviors\Constant;

use Yii;
use \common\models\base\MapLayer as BaseMapLayer;

/**
 * This is the model class for table "map_layer".
 */
class MapLayer extends BaseMapLayer
{
	use Constant;
	const STATUS_ENABLED = 'ENABLED';
	const STATUS_DISABLED = 'DISABLED';
	
}
