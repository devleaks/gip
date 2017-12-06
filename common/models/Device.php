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

	public static function import($geojson) {
		if(in_array($geojson->type, ["Feature","Point"])) {
			$device = new Device();
			$device = CaptureImport::featureAttributes($device, $geojson);
	
			$device->save();
			$device->refresh();
			return $device;
		}
		return null;			
	}
}
