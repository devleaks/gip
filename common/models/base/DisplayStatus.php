<?php

namespace common\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the base model class for table "display_status".
 *
 * @property integer $id
 * @property integer $display_status_type_id
 * @property string $name
 * @property string $display_name
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $style_id
 *
 * @property \common\models\DisplayStatusType $displayStatusType
 * @property \common\models\Style $style
 */
class DisplayStatus extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['display_status_type_id', 'name', 'display_name'], 'required'],
            [['display_status_type_id', 'created_by', 'updated_by', 'style_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'display_name'], 'string', 'max' => 40],
            [['description'], 'string', 'max' => 2000],
            [['name'], 'unique'],
            [['display_name'], 'unique']
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'display_status';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('gip', 'ID'),
            'display_status_type_id' => Yii::t('gip', 'Display Status Type ID'),
            'name' => Yii::t('gip', 'Name'),
            'display_name' => Yii::t('gip', 'Display Name'),
            'description' => Yii::t('gip', 'Description'),
            'style_id' => Yii::t('gip', 'Style ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDisplayStatusType()
    {
        return $this->hasOne(\common\models\DisplayStatusType::className(), ['id' => 'display_status_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStyle()
    {
        return $this->hasOne(\common\models\Style::className(), ['id' => 'style_id']);
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
     * @return \common\models\query\DisplayStatusQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\DisplayStatusQuery(get_called_class());
    }
}
