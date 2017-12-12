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
			if($root = Type::findOne(['name' => Type::className()])) {
				if($type = Type::findOne(['type_id' => $root->id, 'name' => $classname])) {
						if($types = Type::find()->where(['type_id' => $type->id])->orderBy('display_name')->asArray()->all()) {
							return ArrayHelper::map($types, 'id', 'display_name');
						}
				}
			}
			return [];
		}

		public function toJson() {
			$j = $this->toArray(['name','display_name','description']);
			if(isset($j['id'])) unset($j['id']);
			if($this->id != $this->type_id) $j['type'] = Type::findOne($this->type_id)->toJson();
			return $j;
	 	}

}
