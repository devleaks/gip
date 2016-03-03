<?php

namespace common\models;

use common\behaviors\Constant;

use Yii;
use \common\models\base\Wire as BaseWire;

/**
 * This is the model class for table "wire".
 */
class Wire extends BaseWire
{
	use Constant;
	
	const STATUS_PUSBLISHED = 'PUBLISHED';
	const STATUS_READ = 'READ';
	const STATUS_ARCHIVED = 'ARCHIVED';
	
}
