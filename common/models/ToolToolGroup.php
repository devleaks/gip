<?php

namespace common\models;

use Yii;
use \common\models\base\ToolToolGroup as BaseToolToolGroup;

/**
 * This is the model class for table "tool_tool_group".
 */
class ToolToolGroup extends BaseToolToolGroup
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['tool_group_id', 'tool_id'], 'required'],
            [['tool_group_id', 'tool_id', 'created_by', 'updated_by'], 'integer'],
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
            'tool_group_id' => Yii::t('gip', 'Tool Group ID'),
            'tool_id' => Yii::t('gip', 'Tool ID'),
            'created_at' => Yii::t('gip', 'Created At'),
            'updated_at' => Yii::t('gip', 'Updated At'),
            'created_by' => Yii::t('gip', 'Created By'),
            'updated_by' => Yii::t('gip', 'Updated By'),
        ];
    }

	
}
