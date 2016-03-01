<?php

namespace common\behaviors;

use Yii;
use yii\base\Behavior;

/**
 *	Attribute behavior/trait adds function to fetch linked attributes.
 */
trait Attribute {

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
        return \common\models\EntityAttribute::find()->where([
			'entity_type' => $this::className(),
			'entity_id'   => $this->id
		]);
    }

}
