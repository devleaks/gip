<?php

namespace common\models;

use Yii;
use \common\models\base\Notification as BaseNotification;

/**
 * This is the model class for table "notification".
 */
class Notification extends BaseNotification
{
    /**
     * @return \yii\db\ActiveQuery
     */
    public function createParameters()
    {
		if($this->notificationType->hasParameters()) {
			$attribute_ids = [];
			foreach(EntityAttribute::find()->where(['entity_id' => $this->notification_type_id,
													'entity_type' => NotificationType::className()
													])->each() as $ea) {
				$attribute_ids[] = $ea->attribute_id;
				// add missing atributes
				if(! AttributeValue::find()->where(['entity_id' => $this->id,
													'entity_type' => $this::className(),
													'attribute_id' => $ea->attribute_id
													])->exists()) {
					Yii::trace('adding'.$ea->id, 'Notification::createParameters');
					$av = new AttributeValue();
					$av->attribute_id = $ea->attribute_id;
					$av->entity_id = $this->id;
					$av->entity_type = $this::className();
					$av->save();
				}
			}
			// remove unused attributes
			foreach(AttributeValue::find()->where(['entity_id' => $this->id, 'entity_type' => $this::className()])
										  ->andWhere(['not', ['attribute_id' => $attribute_ids]])
										  ->each() as $av) {
				$av->delete();
			}
		}
    }

    protected function getParameters_i()
    {
		return  AttributeValue::find()->andWhere([
			'attribute_id' => EntityAttribute::find()->where(['entity_id' => $this->notification_type_id,
															  'entity_type' => NotificationType::className()
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
		Yii::trace('count '.$cnt, 'Notification::hasParameters');
        return $cnt > 0;
    }
}
