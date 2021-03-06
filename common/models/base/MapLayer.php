<?php

namespace common\models\base;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the base model class for table "map_layer".
 *
 * @property integer $id
 * @property integer $map_id
 * @property integer $layer_id
 * @property integer $position
 * @property string $group
 * @property integer $default
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property \common\models\Map $map
 * @property \common\models\Layer $layer
 */
class MapLayer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['map_id', 'layer_id'], 'required'],
            [['map_id', 'layer_id', 'position', 'default', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['group', 'status'], 'string', 'max' => 40]
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'map_layer';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('gip', 'ID'),
            'map_id' => Yii::t('gip', 'Map'),
            'layer_id' => Yii::t('gip', 'Layer'),
            'position' => Yii::t('gip', 'Position'),
            'group' => Yii::t('gip', 'Group'),
            'default' => Yii::t('gip', 'Default'),
            'status' => Yii::t('gip', 'Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMap()
    {
        return $this->hasOne(\common\models\Map::className(), ['id' => 'map_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLayer()
    {
        return $this->hasOne(\common\models\Layer::className(), ['id' => 'layer_id']);
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
     * @return \common\models\query\MapLayerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\MapLayerQuery(get_called_class());
    }
}
