<?php

namespace common\models\base;

use Yii;
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
 * @property integer $type_id
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property string $group_type
 * @property integer $remote_group_id
 *
 * @property \common\models\RemoteGroup $remoteGroup
 * @property \common\models\Type $type
 * @property \common\models\DisplayStatusType $displayStatusType
 * @property \common\models\ZoneZoneGroup[] $zoneZoneGroups
 */
class ZoneGroup extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;


    /**
    * This function helps \mootensai\relation\RelationTrait runs faster
    * @return array relation names of this model
    */
    public function relationNames()
    {
        return [
            'remoteGroup',
            'type',
            'displayStatusType',
            'zoneZoneGroups'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'display_name'], 'required'],
            [['display_status_type_id', 'type_id', 'created_by', 'updated_by', 'remote_group_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['group_type'], 'string'],
            [['name', 'display_name', 'status'], 'string', 'max' => 40],
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
        return 'zone_group';
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
            'display_status_type_id' => Yii::t('app', 'Display Status Type ID'),
            'type_id' => Yii::t('app', 'Type ID'),
            'status' => Yii::t('app', 'Status'),
            'group_type' => Yii::t('app', 'Group Type'),
            'remote_group_id' => Yii::t('app', 'Remote Group ID'),
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRemoteGroup()
    {
        return $this->hasOne(\common\models\RemoteGroup::className(), ['id' => 'remote_group_id']);
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
    public function getZoneZoneGroups()
    {
        return $this->hasMany(\common\models\ZoneZoneGroup::className(), ['zone_group_id' => 'id']);
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
     * @return \common\models\query\ZoneGroupQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\ZoneGroupQuery(get_called_class());
    }
}
