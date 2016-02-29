<?php

namespace common\models;

use Yii;
use \common\models\base\Provider as BaseProvider;

/**
 * This is the model class for table "provider".
 */
class Provider extends BaseProvider
{
    /**
     * @return \yii\db\ActiveQuery
     */
    public function createParameters()
    {
		if($this->providerType->hasParameters() && !$this->hasParameters()) {
			foreach(EntityAttribute::find()->where(['entity_id' => $this->provider_type_id,
													'entity_type' => ProviderType::className()
													])->each() as $ea) {
				Yii::trace('adding'.$ea->id, 'Provider::createParameters');
				$av = new AttributeValue();
				$av->attribute_id = $ea->attribute_id;
				$av->entity_id = $this->id;
				$av->entity_type = $this::className();
				$av->save();
			}
		}
    }

    protected function getParameters_i()
    {
		return  AttributeValue::find()->andWhere([
			'attribute_id' => EntityAttribute::find()->where(['entity_id' => $this->provider_type_id,
															  'entity_type' => ProviderType::className()
															 ])->select('attribute_id'),
			'entity_type' => $this::className(),
			'entity_id' => $this->id
			
		]);
    }

    public function getParameters($create = false)
    {
		$r = $this->getParameters_i();
		$q = clone $r;
		
		if(($q->count() == 0) && $create) {
			Yii::trace('no av', 'Provider::getParameters');
			$this->createParameters();
			$r = $this->getParameters(false);
		}
			
		return $r;
    }

    /**
     * @return boolean
     */
    public function hasParameters()
    {
		$cnt = $this->getParameters_i()->count();
		Yii::trace('count '.$cnt, 'Provider::hasParameters');
        return $cnt > 0;
    }
}
