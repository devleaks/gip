<?php

namespace common\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the base model class for table "type".
 *
 * @property integer $id
 * @property integer $type_id
 * @property string $name
 * @property string $display_name
 * @property string $description
 * @property string $icon
 * @property string $color
 * @property string $created_at
 * @property string $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $style_id
 *
 * @property \common\models\Device[] $devices
 * @property \common\models\DeviceGroup[] $deviceGroups
 * @property \common\models\Event[] $events
 * @property \common\models\Presentation[] $presentations
 * @property \common\models\Tool[] $tools
 * @property \common\models\ToolGroup[] $toolGroups
 * @property \common\models\Type $type
 * @property \common\models\Type[] $types
 * @property \common\models\Style $style
 * @property \common\models\Wire[] $wires
 * @property \common\models\Zone[] $zones
 * @property \common\models\ZoneGroup[] $zoneGroups
 */
class Type extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type_id', 'name', 'display_name'], 'required'],
            [['type_id', 'created_by', 'updated_by', 'style_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'display_name', 'icon', 'color'], 'string', 'max' => 40],
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
        return 'type';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('gip', 'ID'),
            'type_id' => Yii::t('gip', 'Type ID'),
            'name' => Yii::t('gip', 'Name'),
            'display_name' => Yii::t('gip', 'Display Name'),
            'description' => Yii::t('gip', 'Description'),
            'icon' => Yii::t('gip', 'Icon'),
            'color' => Yii::t('gip', 'Color'),
            'style_id' => Yii::t('gip', 'Style ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDevices()
    {
        return $this->hasMany(\common\models\Device::className(), ['type_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeviceGroups()
    {
        return $this->hasMany(\common\models\DeviceGroup::className(), ['type_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvents()
    {
        return $this->hasMany(\common\models\Event::className(), ['type_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPresentations()
    {
        return $this->hasMany(\common\models\Presentation::className(), ['type_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTools()
    {
        return $this->hasMany(\common\models\Tool::className(), ['type_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getToolGroups()
    {
        return $this->hasMany(\common\models\ToolGroup::className(), ['type_id' => 'id']);
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
    public function getTypes()
    {
        return $this->hasMany(\common\models\Type::className(), ['type_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStyle()
    {
        return $this->hasOne(\common\models\Style::className(), ['id' => 'style_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWires()
    {
        return $this->hasMany(\common\models\Wire::className(), ['type_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getZones()
    {
        return $this->hasMany(\common\models\Zone::className(), ['type_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getZoneGroups()
    {
        return $this->hasMany(\common\models\ZoneGroup::className(), ['type_id' => 'id']);
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
     * @return \common\models\query\TypeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\TypeQuery(get_called_class());
    }
}
