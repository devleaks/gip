<?php

namespace common\models\base;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the base model class for table "device_group".
 *
 * @property integer $id
 * @property string $name
 * @property string $display_name
 * @property string $description
 * @property integer $display_status_type_id
 * @property string $group_type
 * @property integer $type_id
 * @property string $created_at
 * @property string $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property \common\models\DeviceDeviceGroup[] $deviceDeviceGroups
 * @property \common\models\Type $type
 * @property \common\models\DisplayStatusType $displayStatusType
 * @property \common\models\Rule[] $rules
 */
class DeviceGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'display_name'], 'required'],
            [['display_status_type_id', 'type_id', 'created_by', 'updated_by'], 'integer'],
            [['group_type'], 'string'],
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
        return 'device_group';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('gip', 'ID'),
            'name' => Yii::t('gip', 'Name'),
            'display_name' => Yii::t('gip', 'Display Name'),
            'description' => Yii::t('gip', 'Description'),
            'display_status_type_id' => Yii::t('gip', 'Display Status Type ID'),
            'group_type' => Yii::t('gip', 'Group Type'),
            'type_id' => Yii::t('gip', 'Type ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeviceDeviceGroups()
    {
        return $this->hasMany(\common\models\DeviceDeviceGroup::className(), ['device_group_id' => 'id']);
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
    public function getDisplayStatusType()
    {
        return $this->hasOne(\common\models\DisplayStatusType::className(), ['id' => 'display_status_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRules()
    {
        return $this->hasMany(\common\models\Rule::className(), ['device_group_id' => 'id']);
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
     * @return \common\models\query\DeviceGroupQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\DeviceGroupQuery(get_called_class());
    }
}
