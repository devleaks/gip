<?php

namespace common\models;

use Yii;
use \common\models\base\MapToolGroup as BaseMapToolGroup;

/**
 * This is the model class for table "map_tool_group".
 */
class MapToolGroup extends BaseMapToolGroup
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['map_id', 'tool_group_id'], 'required'],
            [['map_id', 'tool_group_id', 'position', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe']
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('gip', 'ID'),
            'map_id' => Yii::t('gip', 'Map'),
            'tool_group_id' => Yii::t('gip', 'Tool Group'),
            'position' => Yii::t('gip', 'Position'),
            'created_at' => Yii::t('gip', 'Created At'),
            'updated_at' => Yii::t('gip', 'Updated At'),
            'created_by' => Yii::t('gip', 'Created By'),
            'updated_by' => Yii::t('gip', 'Updated By'),
        ];
    }

	
}
