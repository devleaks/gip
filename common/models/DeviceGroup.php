<?php

namespace common\models;

use Yii;
use \common\models\base\DeviceGroup as BaseDeviceGroup;

/**
 * This is the model class for table "device_group".
 */
class DeviceGroup extends BaseDeviceGroup
{
	use \common\behaviors\ListAll;
	
	public function getDevices() {
		if($this->device_type != '') {
			return Device::find()->where(['device_type' => $this->device_type]);
		} else {
		    return $this->hasMany(Device::className(), ['id' => 'device_id'])->viaTable('device_device_group', ['device_group_id' => 'id']);
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
