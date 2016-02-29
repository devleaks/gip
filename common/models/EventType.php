<?php

namespace common\models;

use Yii;
use \common\models\base\EventType as BaseEventType;

/**
 * This is the model class for table "event_type".
 */
class EventType extends BaseEventType
{
	const EVENT_TYPE_SOURCE = 'Source Event';
	const EVENT_TYPE_TARGET = 'Target Event';
		
	public static function getSourceEventID() {
		return EventType::findOne(['name' => self::EVENT_TYPE_SOURCE])->id;
	}

	public static function getTargetEventID() {
		return EventType::findOne(['name' => self::EVENT_TYPE_TARGET])->id;
	}
}
