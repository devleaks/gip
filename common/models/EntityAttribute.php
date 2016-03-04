<?php

namespace common\models;

use Yii;
use \common\models\base\EntityAttribute as BaseEntityAttribute;

/**
 * This is the model class for table "entity_attribute".
 */
class EntityAttribute extends BaseEntityAttribute
{
		public function getEntityName() {
			$class = $this->entity_type;
			if($model = $class::findOne($this->entity_id))
				return $model->name;
			else
				return $this->entity_type.'('.$this->entity_id.')';
		}
}
