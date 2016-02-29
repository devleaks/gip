<?php

namespace common\models;

use Yii;
use \common\models\base\NotificationType as BaseNotificationType;

/**
 * This is the model class for table "notification_type".
 */
class NotificationType extends BaseNotificationType
{

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParameters()
    {
        return $this->hasMany(\common\models\Attribute::className(), ['id' => 'attribute_id'])->viaTable('notification_type_attribute', ['entity_id' => 'id']);
    }
}
