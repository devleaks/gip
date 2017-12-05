<?php

namespace common\behaviors;

use common\models\AttributeValue as AttributeValueModel;
use common\models\EntityAttribute;

use Yii;
use yii\base\Behavior;

/**
 *	Attribute behavior/trait adds function to fetch linked attributes.
 */
trait AttributeValue {

    /**
     * @return \yii\db\ActiveQuery
     */
    public function createParameters()
    {
		if($this->getType()->hasParameters()) {
			$entity_attribute_ids = [];
			$class = $this->getType();
			//Yii::trace('classname='.$class::className(), 'AttributeValue::createParameters');
			foreach(EntityAttribute::find()->where(['entity_id' => $this->getType()->id,
													'entity_type' => $class::className()
													])->each() as $ea) {
				$entity_attribute_ids[] = $ea->id;
				// add missing atributes
				if(! AttributeValueModel::find()->where(['entity_id' => $this->id,
														 'entity_type' => $this::className(),
														 'entity_attribute_id' => $ea->id
														])->exists()) {
					Yii::trace('adding '.$ea->id, 'Detection::createParameters');
					$av = new AttributeValueModel();
					$av->entity_attribute_id = $ea->id;
//					$av->attribute_id = $ea->attribute_id;
					$av->entity_id = $this->id;
					$av->entity_type = $this::className();
					$av->save();
				}
			}
			// remove unused attributes
			foreach(AttributeValueModel::find()->where(['entity_id' => $this->id, 'entity_type' => $this::className()])
										  	   ->andWhere(['not', ['entity_attribute_id' => $entity_attribute_ids]])
										  	   ->each() as $av) {
				$av->delete();
			}
		}
    }

    protected function getParameters_i()
    {
		$class = $this->getType();
		return  AttributeValueModel::find()->andWhere([
			'entity_attribute_id' => EntityAttribute::find()->where(['entity_id' => $this->getType()->id,
															  'entity_type' => $class::className()
															 ])->select('id'),
			'entity_type' => $this::className(),
			'entity_id' => $this->id
		]);
    }

    public function getParameters($create = false)
    {
		if($create) {
			$this->createParameters();
		}

		return $this->getParameters_i();
    }

	public function getAttributeValues() {
		$attrvals = [];
		foreach($this->getParameters()->each() as $av) {
			$attrvals[$av->getName()] = $av->getValue();
		}
		return $attrvals;
	}

    /**
     * @return boolean
     */
    public function hasParameters()
    {
		$cnt = $this->getParameters_i()->count();
		//Yii::trace('count '.$cnt, 'Detection::hasParameters');
        return $cnt > 0;
    }

}
