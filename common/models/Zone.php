<?php

namespace common\models;

use Yii;
use \common\models\base\Zone as BaseZone;
use backend\models\CaptureImport;

/**
 * This is the model class for table "zone".
 */
class Zone extends BaseZone
{
	public static function getZoneTypes() {
		return Type::forClass(Zone::className());
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
			$zone = new Zone();
			$zone = CaptureImport::featureAttributes($zone, $geojson);

			$first_coord = ($geojson->type == "Feature") ? $geojson->geometry->coordinates[0] : $geojson->coordinates[0];
			$zone->zone_dimension = (count($first_coord) == 3) ? Zone::ZONE_DIMENSION_3D : Zone::ZONE_DIMENSION_2D;
			
			$zone->save();
			$zone->refresh();
			return $zone;
		}
		return null;			
	}
}
