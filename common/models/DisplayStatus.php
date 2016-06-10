<?php

namespace common\models;

use Yii;
use \common\models\base\DisplayStatus as BaseDisplayStatus;

/**
 * This is the model class for table "display_status".
 */
class DisplayStatus extends BaseDisplayStatus
{
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('gip', 'ID'),
            'display_status_type_id' => Yii::t('gip', 'Display Status Type'),
            'name' => Yii::t('gip', 'Name'),
            'display_name' => Yii::t('gip', 'Display Name'),
            'description' => Yii::t('gip', 'Description'),
            'created_at' => Yii::t('gip', 'Created At'),
            'updated_at' => Yii::t('gip', 'Updated At'),
            'created_by' => Yii::t('gip', 'Created By'),
            'updated_by' => Yii::t('gip', 'Updated By'),
            'style_id' => Yii::t('gip', 'Style Name'),
        ];
    }

	
}
