<?php

namespace common\behaviors;

use Yii;
use yii\base\Behavior;

/**
 *	Attribute behavior/trait adds function to fetch linked attributes.
 */
trait Group {
	
	public function getItems() {
		$class = $this::className();
		if($this->getType() != '') {
			return $class::find()->where(['device_type' => $this->device_type]);
		} else {
		    return $this->hasMany($class, ['id' => 'device_id'])->viaTable('device_device_group', ['device_group_id' => 'id']);
		}
	}
	
	public function add($device) {
		if(! DeviceDeviceGroup::findOne(['device_group_id' => $this->id, 'device_id' => $device->id]) ) {
			$ddg = new DeviceDeviceGroup([
				'device_id' => $device->id,
				'device_group_id' => $this->id,
			]);
			$ddg->save();
			//Yii::trace('errors '.print_r($model->errors, true), 'DeviceGroup::add');
		}
		return false;
	}

	public function remove($device) {
		if($ddg = DeviceDeviceGroup::findOne(['device_group_id' => $this->id, 'device_id' => $device->id])) {
			return $ddg->delete();
		}
		return false;
	}

}
