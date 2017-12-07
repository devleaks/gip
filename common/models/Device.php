<?php

namespace common\models;

use Yii;
use \common\models\base\Device as BaseDevice;
use backend\models\CaptureImport;

/**
 * This is the model class for table "device".
 */
class Device extends BaseDevice
{
	public static function getDeviceTypes() {
		return Type::forClass(Device::className());
	}

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(\common\models\Type::className(), ['id' => 'type_id']);
    }

	public function fields() {
		$fields = parent::fields();
		if(isset($fields['id'])) unset ($fields['id']);
		$fields[] = 'type';
		return $fields;
	}

	public static function fromGeoJson($geojson) {
		if(in_array($geojson->type, ["Feature","Point"])) {
			$device = new Device();
			$device = CaptureImport::featureAttributes($device, $geojson);
	
			$device->save();
			$device->refresh();
			return $device;
		}
		return null;			
	}
	
	public function toGeoJson() {
		$e = [];
		$e['type'] = 'Feature';
		$e['properties'] = $this->toArray(['id','name','display_name','description','type_id','status','created_at','updated_at','created_by','updated_by']);
		
		if($this->geojson != '') {
			$g = json_decode($this->geojson);
			$e['geometry'] = isset($g->geometry) ? $g->geometry : $g;
		} else { // supply default geometry to validate geojson
			$e['geometry'] = [
				'type' => "Point",
				'coordinates' => [0, 0]
			];
		}
		//Yii::trace(print_r($e, true), 'Device::export');
		//Yii::trace(json_encode($e, JSON_PRETTY_PRINT), 'Device::export');

		return $e;
 	}
	
}
