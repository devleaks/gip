<?php

namespace common\models;

use common\behaviors\Constant;

use Yii;
use \common\models\base\Processing as BaseProcessing;

/**
 * This is the model class for table "processing".
 */
class Processing extends BaseProcessing
{
	use Constant;
	const STATUS_ENABLED = 'ENABLED';
	const STATUS_DISABLED = 'DISABLED';
	
}
