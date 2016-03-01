<?php

namespace common\models;

use Yii;
use \common\models\base\Device as BaseDevice;

/**
 * This is the model class for table "device".
 */
class Device extends BaseDevice
{
		public static function getDeviceTypes() {
			$dt = [];
			foreach(Device::find()->select('device_type')->distinct()->each() as $d) {
				$dt[$d->device_type] = $d->device_type;
			}
			return $dt;
		}
}
