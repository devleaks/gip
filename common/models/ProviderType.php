<?php

namespace common\models;

use Yii;
use \common\models\base\ProviderType as BaseProviderType;

/**
 * This is the model class for table "provider_type".
 */
class ProviderType extends BaseProviderType
{
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParameters()
    {
        return $this->hasMany(\common\models\Attribute::className(), ['id' => 'attribute_id'])->viaTable('provider_type_attribute', ['entity_id' => 'id']);
    }

    /**
     * @return boolean
     */
    public function hasParameters()
    {
		$cnt = $this->getParameters()->count();
		Yii::trace('count '.$cnt, 'ProviderType::hasParameters');
        return $cnt > 0;
    }
}
