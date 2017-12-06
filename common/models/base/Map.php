<?php

namespace common\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the base model class for table "map".
 *
 * @property integer $id
 * @property string $name
 * @property string $display_name
 * @property string $center
 * @property string $zoom
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property \common\models\MapLayer[] $mapLayers
 * @property \common\models\MapToolGroup[] $mapToolGroups
 */
class Map extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;


    /**
    * This function helps \mootensai\relation\RelationTrait runs faster
    * @return array relation names of this model
    */
    public function relationNames()
    {
        return [
            'mapLayers',
            'mapToolGroups'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'display_name'], 'required'],
            [['zoom'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
            [['name', 'display_name', 'center'], 'string', 'max' => 40],
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
        return 'map';
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
            'center' => Yii::t('app', 'Center'),
            'zoom' => Yii::t('app', 'Zoom'),
            'description' => Yii::t('app', 'Description'),
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMapLayers()
    {
        return $this->hasMany(\common\models\MapLayer::className(), ['map_id' => 'id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMapToolGroups()
    {
        return $this->hasMany(\common\models\MapToolGroup::className(), ['map_id' => 'id']);
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
     * @return \common\models\query\MapQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\MapQuery(get_called_class());
    }
}
