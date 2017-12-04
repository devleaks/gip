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
}
