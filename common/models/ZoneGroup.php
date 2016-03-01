<?php

namespace common\models;

use Yii;
use \common\models\base\ZoneGroup as BaseZoneGroup;

/**
 * This is the model class for table "zone_group".
 */
class ZoneGroup extends BaseZoneGroup
{
	public function getZones() {
		if($this->zone_type != '') {
			return Zone::find()->where(['zone_type' => $this->zone_type]);
		} else {
		    return $this->hasMany(Zone::className(), ['id' => 'zone_id'])->viaTable('zone_zone_group', ['zone_group_id' => 'id']);
		}
	}
	
	public function add($device) {
		if(! ZoneZoneGroup::findOne(['zone_group_id' => $this->id, 'zone_id' => $device->id]) ) {
			$ddg = new ZoneZoneGroup([
				'zone_id' => $device->id,
				'zone_group_id' => $this->id,
			]);
			$ddg->save();
		}
		return false;
	}

	public function remove($device) {
		if($ddg = ZoneZoneGroup::findOne(['zone_group_id' => $this->id, 'zone_id' => $device->id])) {
			return $ddg->delete();
		}
		return false;
	}
}
