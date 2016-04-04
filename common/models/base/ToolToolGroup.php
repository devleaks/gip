<?php

namespace common\models\base;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the base model class for table "tool_tool_group".
 *
 * @property integer $id
 * @property integer $tool_group_id
 * @property integer $tool_id
 * @property string $created_at
 * @property string $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property \common\models\ToolGroup $toolGroup
 * @property \common\models\Tool $tool
 */
class ToolToolGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tool_group_id', 'tool_id'], 'required'],
            [['tool_group_id', 'tool_id', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe']
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tool_tool_group';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('gip', 'ID'),
            'tool_group_id' => Yii::t('gip', 'Tool Group'),
            'tool_id' => Yii::t('gip', 'Tool'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getToolGroup()
    {
        return $this->hasOne(\common\models\ToolGroup::className(), ['id' => 'tool_group_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTool()
    {
        return $this->hasOne(\common\models\Tool::className(), ['id' => 'tool_id']);
    }

/**
     * @inheritdoc
     * @return type mixed
     */ 
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new \yii\db\Expression('NOW()'),
            ],
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\query\ToolToolGroupQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\ToolToolGroupQuery(get_called_class());
    }
}
