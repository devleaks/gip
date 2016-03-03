<?php

namespace common\models;

use common\behaviors\Constant;

use Yii;
use yii\helpers\ArrayHelper;
use \common\models\base\EntityType as BaseEntityType;

/**
 * This is the model class for table "entity_type".
 */
class EntityType extends BaseEntityType
{
	use Constant;
	
	const CATEGORY_EVENT = 'EVENT';
	const CATEGORY_WIRE = 'WIRE';
	const CATEGORY_ZONE = 'WIRE';
	const CATEGORY_DEVICE = 'DEVICE';
	
	static public function getTypes($category) {
		return self::find()->where(['category' => $category]);
	}

	static public function getTypesList($category) {
		return ArrayHelper::map(self::getTypes($category)->asArray()->all(), 'id', 'name');
	}

}
