<?php

namespace common\behaviors;

use Yii;
use yii\base\Behavior;
use yii\helpers\ArrayHelper;

/**
 *	Attribute behavior/trait adds function to fetch linked attributes.
 */
trait Attribute {

    /**
	 * Note: Should be called getAttributes but conflicts with Yii2 ActiveRecord Model.
	 *
     * @return \yii\db\ActiveQuery
     */
    public function getParameters()
    {
        return \common\models\Attribute::find()->where(['id' => $this->getEntityAttributes()->select('attribute_id')]);
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


    /**
     * @return array()[id] = name
     */
    public function getParametersList()
    {
		return ArrayHelper::map($this->getParameters()->all(), 'id', 'name');
    }

}
