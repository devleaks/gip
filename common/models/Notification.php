<?php

namespace common\models;

use common\behaviors\AttributeValue;

use Yii;
use \common\models\base\Notification as BaseNotification;

/**
 * This is the model class for table "notification".
 */
class Notification extends BaseNotification
{
	use AttributeValue;
	
	public function getType() {
		return $this->notificationType;
	}
}
