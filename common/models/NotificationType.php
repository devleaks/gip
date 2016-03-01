<?php

namespace common\models;

use common\behaviors\Attribute;

use Yii;
use \common\models\base\NotificationType as BaseNotificationType;

/**
 * This is the model class for table "notification_type".
 */
class NotificationType extends BaseNotificationType
{
	use Attribute;

}
