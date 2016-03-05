<?php

namespace common\models;

use common\behaviors\Constant;

use Yii;
use \common\models\base\Processing as BaseProcessing;

/**
 * This is the model class for table "processing".
 */
class Processing extends BaseProcessing
{
	use Constant;
	const STATUS_ENABLED = 'ENABLED';
	const STATUS_DISABLED = 'DISABLED';
	
    /**
     * @return \yii\db\ActiveQuery
     */
    protected function createMappings()
    {
		if($oe = $this->getTarget()->one()->getEvent()->one()) {
			Yii::trace('event out='.$oe->id, 'Processing::createMappings');
			$attribute_ids = [];
			foreach($oe->getEntityAttributes()->each() as $ea) {
				Yii::trace('add out attr='.$ea->attribute_id, 'Processing::createMappings');
				$attribute_ids[] = $ea->attribute_id;
				// add missing atributes
				if(! Mapping::find()->where(['processing_id' => $this->id,
											 'attribute_out' => $ea->attribute_id
											])->exists()) {
					Yii::trace('adding '.$ea->id, 'Processing::createMappings');
					$av = new Mapping();
					$av->processing_id = $this->id;
					$av->attribute_out = $ea->attribute_id;
					$av->save();
				}
			}
			// remove unused attributes
			foreach(Mapping::find()->where(['processing_id' => $this->id,])
										  ->andWhere(['not', ['attribute_out' => $attribute_ids]])
										  ->each() as $ea) {
				$ea->delete();
			}
		}
    }

    protected function getParameters_i()
    {
		return  Mapping::find()->andWhere([
			'processing_id' => $this->id]);
    }

    public function getMappings($create = false)
    {
		if($create) {
			$this->createMappings();
		}

		return parent::getMappings();
    }

    /**
     * @return boolean
     */
    public function hasMappings()
    {
		$cnt = $this->getParameters_i()->count();
		Yii::trace('count '.$cnt, 'Processing::hasMappings');
        return $cnt > 0;
    }
}
