<?php

namespace common\models;

use Yii;
use \common\models\base\Event as BaseEvent;

/**
 * This is the model class for table "event".
 */
class Event extends BaseEvent
{
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParameters()
    {
        return $this->hasMany(\common\models\Attribute::className(), ['id' => 'attribute_id'])->viaTable('event_attribute', ['entity_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntityAttributes()
    {
        return EntityAttribute::find()->where([
			'entity_type' => $this::className(),
			'entity_id'   => $this->id
		]);
    }
}
