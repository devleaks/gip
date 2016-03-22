<?php

namespace common\models\base;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the base model class for table "map_background".
 *
 * @property integer $id
 * @property integer $map_id
 * @property integer $background_id
 * @property integer $position
 * @property string $created_at
 * @property string $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property \common\models\Map $map
 * @property \common\models\Background $background
 */
class MapBackground extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['map_id', 'background_id'], 'required'],
            [['map_id', 'background_id', 'position', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe']
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'map_background';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('gip', 'ID'),
            'map_id' => Yii::t('gip', 'Map ID'),
            'background_id' => Yii::t('gip', 'Background ID'),
            'position' => Yii::t('gip', 'Position'),
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
    public function getBackground()
    {
        return $this->hasOne(\common\models\Background::className(), ['id' => 'background_id']);
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
     * @return \common\models\query\MapBackgroundQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\MapBackgroundQuery(get_called_class());
    }
}
