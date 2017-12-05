<?php

namespace common\models;

use Yii;
use \common\models\base\Device as BaseDevice;

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
}
