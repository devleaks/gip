<?php

namespace common\models\base;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the base model class for table "zone_group".
 *
 * @property integer $id
 * @property string $name
 * @property string $display_name
 * @property string $description
 * @property integer $display_status_type_id
 * @property string $zone_group_type
 * @property integer $type_id
 * @property string $schema_name
 * @property string $table_name
 * @property string $unique_id_column
 * @property string $geometry_column
 * @property string $where_clause
 * @property string $created_at
 * @property string $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property \common\models\DisplayStatusType $displayStatusType
 * @property \common\models\Type $type
 * @property \common\models\ZoneZoneGroup[] $zoneZoneGroups
 */
class ZoneGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'display_name'], 'required'],
            [['display_status_type_id', 'type_id', 'created_by', 'updated_by'], 'integer'],
            [['zone_group_type'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'display_name'], 'string', 'max' => 40],
            [['description'], 'string', 'max' => 2000],
            [['schema_name', 'table_name', 'unique_id_column', 'geometry_column'], 'string', 'max' => 80],
            [['where_clause'], 'string', 'max' => 4000],
            [['name'], 'unique'],
            [['display_name'], 'unique']
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'zone_group';
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
            'zone_group_type' => Yii::t('gip', 'Zone Group Type'),
            'type_id' => Yii::t('gip', 'Type ID'),
            'schema_name' => Yii::t('gip', 'Schema Name'),
            'table_name' => Yii::t('gip', 'Table Name'),
            'unique_id_column' => Yii::t('gip', 'Unique Id Column'),
            'geometry_column' => Yii::t('gip', 'Geometry Column'),
            'where_clause' => Yii::t('gip', 'Where Clause'),
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
    public function getType()
    {
        return $this->hasOne(\common\models\Type::className(), ['id' => 'type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getZoneZoneGroups()
    {
        return $this->hasMany(\common\models\ZoneZoneGroup::className(), ['zone_group_id' => 'id']);
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
     * @return \common\models\query\ZoneGroupQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\ZoneGroupQuery(get_called_class());
    }
}
