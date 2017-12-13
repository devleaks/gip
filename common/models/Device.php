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

	// return either new object created from GeoJSON or return existing object found by name attribute.
	public static function import($s) {
		return 	CaptureImport::isJson($s) ?
				Device::fromGeoJson($s)
				:
				Device::findOne(['name' => $s]);
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
		$e['properties'] = $this->toArray(['name','display_name','description','status','created_at','updated_at']);
		
		if($this->type_id > 0) {
			$e['properties']['type'] = Type::findOne($this->type_id)->toJson();
		}
		
		if($this->created_by > 0) {
			$e['properties']['created_by'] = User::findOne($this->created_by)->toJson();
		}
		
		if($this->updated_by > 0) {
			$e['properties']['updated_by'] = User::findOne($this->updated_by)->toJson();
		}
		
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
		Yii::trace(json_encode($e, JSON_PRETTY_PRINT), 'Device::export');

		return $e;
 	}
	
}
