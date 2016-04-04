<?php

namespace common\models\base;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the base model class for table "layer".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property string $theme
 * @property string $highlight
 * @property string $icon
 * @property integer $layer_type_id
 * @property string $display_name
 * @property string $status
 *
 * @property \common\models\LayerType $layerType
 * @property \common\models\MapLayer[] $mapLayers
 */
class Layer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'theme'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['created_by', 'updated_by', 'layer_type_id'], 'integer'],
            [['name', 'icon', 'display_name', 'status'], 'string', 'max' => 40],
            [['description'], 'string', 'max' => 2000],
            [['theme', 'highlight'], 'string', 'max' => 80],
            [['name'], 'unique']
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'layer';
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
            'theme' => Yii::t('gip', 'Theme'),
            'highlight' => Yii::t('gip', 'Highlight'),
            'icon' => Yii::t('gip', 'Icon'),
            'layer_type_id' => Yii::t('gip', 'Layer Type'),
            'display_name' => Yii::t('gip', 'Display Name'),
            'status' => Yii::t('gip', 'Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLayerType()
    {
        return $this->hasOne(\common\models\LayerType::className(), ['id' => 'layer_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMapLayers()
    {
        return $this->hasMany(\common\models\MapLayer::className(), ['layer_id' => 'id']);
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
     * @return \common\models\query\LayerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\LayerQuery(get_called_class());
    }
}
