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
}
