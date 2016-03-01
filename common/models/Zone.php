<?php

namespace common\models;

use Yii;
use \common\models\base\Zone as BaseZone;

/**
 * This is the model class for table "zone".
 */
class Zone extends BaseZone
{
	public static function getZoneTypes() {
		$zt = [];
		foreach(Zone::find()->select('zone_type')->distinct()->each() as $d) {
			$zt[$d->zone_type] = $d->zone_type;
		}
		return $zt;
	}
}
