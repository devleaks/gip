<?php

namespace common\models;

use Yii;
use \common\models\base\DeviceGroup as BaseDeviceGroup;
use backend\models\CaptureImport;

/**
 * This is the model class for table "device_group".
 */
class DeviceGroup extends BaseDeviceGroup
{
	use \common\behaviors\ListAll;
	
	public function getDevices() {
		if($this->type_id != '') {
			return Device::find()->where(['type_id' => $this->type_id]);
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
			Yii::trace('errors '.print_r($ddg->errors, true), 'DeviceGroup::add');
			$ddg->save();
			return true;
		}
		return false;
	}

	public function remove($device) {
		if($ddg = DeviceDeviceGroup::findOne(['device_group_id' => $this->id, 'device_id' => $device->id])) {
			return $ddg->delete();
		}
		return false;
	}
	
	public function fields() {
		$fields = parent::fields();
		if(isset($fields['id'])) unset ($fields['id']);
		return $fields;
	}

	public function extraFields() {
		return ['devices','type'];
	}
	
	public static function fromGeoJson($geojson) {
		if($geojson->type != "FeatureCollection" || count($geojson->features) < 1)
			return null;
		$group = new DeviceGroup();
		$group = CaptureImport::featureAttributes($group, $geojson);

		$group->save();
		$group->refresh();
		foreach($geojson->features as $feature) {
			if($feature->geometry->type == "Point") {
				if($device = Device::fromGeoJson($feature)) {
					$group->add($device);
				}
			}
		}
		return $group;
	}
	
	public function toGeoJson() {
		$e = [];
		$e['type'] = 'FeatureCollection';
		$e['properties'] = $this->toArray(['name','display_name','description','status','created_at','updated_at']);;

		if($this->type_id > 0) {
			$e['properties']['type'] = Type::findOne($this->type_id)->toJson();
		}
		
		if($this->created_by > 0) {
			$e['properties']['created_by'] = User::findOne($this->created_by)->toJson();
		}
		
		if($this->updated_by > 0) {
			$e['properties']['updated_by'] = User::findOne($this->updated_by)->toJson();
		}
		
		$e['features'] = [];
		foreach($this->getDevices()->each() as $d) {
			$f = $d->toGeoJson();
			$f['group_name'] = $this->name;
			$f['group_display_name'] = $this->display_name;
			$e['features'][] = $f;
		}
		return $e;
 	}
}
