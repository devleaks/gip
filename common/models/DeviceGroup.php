<?php

namespace common\models;

use Yii;
use \common\models\base\DeviceGroup as BaseDeviceGroup;

/**
 * This is the model class for table "device_group".
 */
class DeviceGroup extends BaseDeviceGroup
{
	
	public function getDevices() {
	    return $this->hasMany(Device::className(), ['id' => 'device_id'])->viaTable('device_device_group', ['device_group_id' => 'id']);
	}
	
	public function add($device) {
		Yii::trace('doing '.$device->id, 'DeviceGroup::add');
		$ddg = new DeviceDeviceGroup([
			'group_id' => $this->id,
			'device2_id' => $device_id
		]);
		if(! $ddg->save())
			Yii::trace('errors '.print_r($model->errors, true), 'DeviceGroup::add');
		Yii::trace('done '.$device->id, 'DeviceGroup::add');
		return;
		Yii::trace('trying '.$device->id, 'DeviceGroup::add');
		$t = false; // DeviceDeviceGroup::findOne(['group_id' => $this->id, 'device_id' => $device->id]);
		Yii::trace('trying '.$device->id.'->'.($t?'t':'f'), 'DeviceGroup::add');
		if(! $t) {
			Yii::trace('adding '.$device->id, 'DeviceGroup::add');
			$ddg = new DeviceDeviceGroup([
				'group_id' => $this->id,
				'device_id' => $device_id
			]);
			if(! $ddg->save())
				Yii::trace('errors '.print_r($model->errors, true), 'DeviceGroup::add');
		}
		return false;
	}

	public function remove($device) {
		if($ddg = DeviceDeviceGroup::findOne(['group_id' => $this->id, 'device_id' => $device->id])) {
			return $ddg->delete();
		}
		return false;
	}
}
