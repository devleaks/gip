<?php

namespace common\behaviors;

use Yii;
use yii\base\Behavior;

/**
 *	Attribute behavior/trait adds function to fetch linked attributes.
 */
trait Group {
	
	public function getEntities() {
		$class = $this::className();
		if($this->getType() != '') {
			return $class::find()->where(['type_id' => $this->type_id]);
		} else {
			$via_table = 'entity_group_'.strtolower($this->getShortName()); // entity_group_zone = select from entity_group where entity_type=zone
		    return $this->hasMany($class, ['id' => 'entity_id'])->viaTable($via_table, ['entity_group_id' => 'id']);
		}
	}
	
	public function add($entity) {
		if(! EntityGroup::findOne(['entity_group_id' => $this->id, 'entity_id' => $entity->id, 'entity_type' => $this::className()]) ) {
			$eg = new EntityGroup([
				'entity_id' => $entity->id,
				'entity_group_id' => $this->id,
				'entity_type' => $this::className()
			]);
			$eg->save();
		}
		return false;
	}

	public function remove($entity) {
		if($eg = EntityGroup::findOne(['entity_group_id' => $this->id, 'entity_id' => $entity->id, 'entity_type' => $this::className()])) {
			return $eg->delete();
		}
		return false;
	}

}
