<?php

namespace common\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the base model class for table "zone".
 *
 * @property integer $id
 * @property string $name
 * @property string $display_name
 * @property string $description
 * @property integer $type_id
 * @property string $zone_dimension
 * @property string $geometry
 * @property string $geojson
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property \common\models\Type $type
 * @property \common\models\ZoneZoneGroup[] $zoneZoneGroups
 */
class Zone extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;


    /**
    * This function helps \mootensai\relation\RelationTrait runs faster
    * @return array relation names of this model
    */
    public function relationNames()
    {
        return [
            'type',
            'zoneZoneGroups'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'display_name', 'zone_dimension'], 'required'],
            [['type_id', 'created_by', 'updated_by'], 'integer'],
            [['zone_dimension', 'geometry', 'geojson'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
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
        return 'zone';
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
            'zone_dimension' => Yii::t('app', 'Zone Dimension'),
            'geometry' => Yii::t('app', 'Geometry'),
            'geojson' => Yii::t('app', 'Geojson'),
            'status' => Yii::t('app', 'Status'),
        ];
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
        return $this->hasMany(\common\models\ZoneZoneGroup::className(), ['zone_id' => 'id']);
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
     * @return \common\models\query\ZoneQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\ZoneQuery(get_called_class());
    }
}
