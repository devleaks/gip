<?php

namespace common\models;

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

use Yii;
use \common\models\base\EntityAttribute as BaseEntityAttribute;

/**
 * This is the model class for table "entity_attribute".
 */
class EntityAttribute extends BaseEntityAttribute
{
	public function getEntityName() {
		$class = $this->entity_type;
		$controller = Inflector::camel2words(StringHelper::basename($class));
		if($model = $class::findOne($this->entity_id))
			return $model->display_name;
		else
			return $this->entity_type.'('.$this->entity_id.')';
	}

	public function getEntityController() {
		return Inflector::camel2id(StringHelper::basename($this->entity_type));
	}

}
