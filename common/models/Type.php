<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

use \common\models\base\Type as BaseType;

/**
 * This is the model class for table "type".
 */
class Type extends BaseType
{
		static public function forClass($classname) {
			$root_id = Type::findOne(['name' => Type::className()])->id;
			$type_id = Type::findOne(['type_id' => $root_id, 'name' => $classname])->id;
			return ArrayHelper::map(Type::find()->where(['type_id' => $type_id])->orderBy('name')->asArray()->all(), 'id', 'name');
		}
}
