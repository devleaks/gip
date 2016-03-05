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
			$attribute_ids = [];
			$class = $this->getType();
			//Yii::trace('classname='.$class::className(), 'AttributeValue::createParameters');
			foreach(EntityAttribute::find()->where(['entity_id' => $this->getType()->id,
													'entity_type' => $class::className()
													])->each() as $ea) {
				$attribute_ids[] = $ea->attribute_id;
				// add missing atributes
				if(! AttributeValueModel::find()->where(['entity_id' => $this->id,
														 'entity_type' => $this::className(),
														 'attribute_id' => $ea->attribute_id
														])->exists()) {
					Yii::trace('adding'.$ea->id, 'Detection::createParameters');
					$av = new AttributeValueModel();
					$av->attribute_id = $ea->attribute_id;
					$av->entity_id = $this->id;
					$av->entity_type = $this::className();
					$av->save();
				}
			}
			// remove unused attributes
			foreach(AttributeValueModel::find()->where(['entity_id' => $this->id, 'entity_type' => $this::className()])
										  	   ->andWhere(['not', ['attribute_id' => $attribute_ids]])
										  	   ->each() as $av) {
				$av->delete();
			}
		}
    }

    protected function getParameters_i()
    {
		$class = $this->getType();
		return  AttributeValueModel::find()->andWhere([
			'attribute_id' => EntityAttribute::find()->where(['entity_id' => $this->getType()->id,
															  'entity_type' => $class::className()
															 ])->select('attribute_id'),
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
