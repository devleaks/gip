<?php

namespace common\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the base model class for table "remote_group".
 *
 * @property integer $id
 * @property string $name
 * @property string $display_name
 * @property string $description
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
 * @property \common\models\DeviceGroup[] $deviceGroups
 * @property \common\models\Type $type
 * @property \common\models\ZoneGroup[] $zoneGroups
 */
class RemoteGroup extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;


    /**
    * This function helps \mootensai\relation\RelationTrait runs faster
    * @return array relation names of this model
    */
    public function relationNames()
    {
        return [
            'deviceGroups',
            'type',
            'zoneGroups'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'display_name'], 'required'],
            [['type_id', 'created_by', 'updated_by'], 'integer'],
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
        return 'remote_group';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'display_name' => Yii::t('app', 'Display Name'),
            'description' => Yii::t('app', 'Description'),
            'type_id' => Yii::t('app', 'Type ID'),
            'schema_name' => Yii::t('app', 'Schema Name'),
            'table_name' => Yii::t('app', 'Table Name'),
            'unique_id_column' => Yii::t('app', 'Unique Id Column'),
            'geometry_column' => Yii::t('app', 'Geometry Column'),
            'where_clause' => Yii::t('app', 'Where Clause'),
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeviceGroups()
    {
        return $this->hasMany(\common\models\DeviceGroup::className(), ['remote_group_id' => 'id']);
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
    public function getZoneGroups()
    {
        return $this->hasMany(\common\models\ZoneGroup::className(), ['remote_group_id' => 'id']);
    }
    
    /**
     * @inheritdoc
     * @return array mixed
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new \yii\db\Expression('NOW()'),
            ],
            'blameable' => [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
        ];
    }


    /**
     * @inheritdoc
     * @return \common\models\query\RemoteGroupQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\RemoteGroupQuery(get_called_class());
    }
}
