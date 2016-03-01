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
        return Attribute::find()->where(['id' => $this->getEntityAttributes()->select('id')]);
    }

    /**
     * @return boolean
     */
    public function hasParameters()
    {
		$cnt = $this->getEntityAttributes()->count();
		Yii::trace('count '.$cnt, 'Attribute::hasParameters');
        return $cnt > 0;
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
