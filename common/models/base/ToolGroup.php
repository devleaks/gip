<?php

namespace common\models\base;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the base model class for table "tool_group".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property string $display_name
 * @property integer $type_id
 *
 * @property \common\models\MapTool[] $mapTools
 * @property \common\models\Type $type
 * @property \common\models\ToolToolGroup[] $toolToolGroups
 */
class ToolGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['created_by', 'updated_by', 'type_id'], 'integer'],
            [['name', 'display_name'], 'string', 'max' => 40],
            [['description'], 'string', 'max' => 2000],
            [['name'], 'unique']
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tool_group';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('gip', 'ID'),
            'name' => Yii::t('gip', 'Name'),
            'description' => Yii::t('gip', 'Description'),
            'display_name' => Yii::t('gip', 'Display Name'),
            'type_id' => Yii::t('gip', 'Type ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMapTools()
    {
        return $this->hasMany(\common\models\MapTool::className(), ['tool_group_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(\common\models\Type::className(), ['id' => 'type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getToolToolGroups()
    {
        return $this->hasMany(\common\models\ToolToolGroup::className(), ['tool_group_id' => 'id']);
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
     * @return \common\models\query\ToolGroupQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\ToolGroupQuery(get_called_class());
    }
}
