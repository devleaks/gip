<?php

namespace common\models;

use common\behaviors\Attribute;

use Yii;
use \common\models\base\Event as BaseEvent;

/**
 * This is the model class for table "event".
 */
class Event extends BaseEvent
{
	use Attribute;

}
