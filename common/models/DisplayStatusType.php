<?php

namespace common\models;

use Yii;
use \common\models\base\DisplayStatusType as BaseDisplayStatusType;

/**
 * This is the model class for table "display_status_type".
 */
class DisplayStatusType extends BaseDisplayStatusType
{
	const DEFAULT = 'GENERIC';
	
	use \common\behaviors\ListAll;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['name', 'display_name'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
            [['name', 'display_name'], 'string', 'max' => 40],
            [['description'], 'string', 'max' => 2000],
            [['name'], 'unique'],
            [['display_name'], 'unique']
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('gip', 'Display Status Type'),
            'name' => Yii::t('gip', 'Name'),
            'display_name' => Yii::t('gip', 'Display Name'),
            'description' => Yii::t('gip', 'Description'),
            'created_at' => Yii::t('gip', 'Created At'),
            'updated_at' => Yii::t('gip', 'Updated At'),
            'created_by' => Yii::t('gip', 'Created By'),
            'updated_by' => Yii::t('gip', 'Updated By'),
        ];
    }

	
}
