<?php

namespace common\models\base;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the base model class for table "giplet".
 *
 * @property integer $id
 * @property string $name
 * @property string $display_name
 * @property string $description
 * @property integer $giplet_type_id
 * @property string $parameters
 * @property integer $width_min
 * @property integer $width_max
 * @property integer $height_min
 * @property integer $height_max
 * @property integer $can_move
 * @property integer $can_resize
 * @property integer $can_minimize
 * @property integer $can_remove
 * @property integer $can_spawn
 * @property integer $has_options
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $width
 * @property integer $height
 * @property integer $locked
 *
 * @property \common\models\DashboardGiplet[] $dashboardGiplets
 * @property \common\models\GipletType $gipletType
 */
class Giplet extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'display_name', 'giplet_type_id'], 'required'],
            [['giplet_type_id', 'width_min', 'width_max', 'height_min', 'height_max', 'can_move', 'can_resize', 'can_minimize', 'can_remove', 'can_spawn', 'has_options', 'created_by', 'updated_by', 'width', 'height', 'locked'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'display_name', 'status'], 'string', 'max' => 40],
            [['description', 'parameters'], 'string', 'max' => 2000],
            [['name'], 'unique'],
            [['display_name'], 'unique']
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'giplet';
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
            'giplet_type_id' => Yii::t('gip', 'Giplet Type'),
            'parameters' => Yii::t('gip', 'Parameters'),
            'width_min' => Yii::t('gip', 'Width Min'),
            'width_max' => Yii::t('gip', 'Width Max'),
            'height_min' => Yii::t('gip', 'Height Min'),
            'height_max' => Yii::t('gip', 'Height Max'),
            'can_move' => Yii::t('gip', 'Can Move'),
            'can_resize' => Yii::t('gip', 'Can Resize'),
            'can_minimize' => Yii::t('gip', 'Can Minimize'),
            'can_remove' => Yii::t('gip', 'Can Remove'),
            'can_spawn' => Yii::t('gip', 'Can Spawn'),
            'has_options' => Yii::t('gip', 'Has Options'),
            'status' => Yii::t('gip', 'Status'),
            'width' => Yii::t('gip', 'Width'),
            'height' => Yii::t('gip', 'Height'),
            'locked' => Yii::t('gip', 'Locked'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDashboardGiplets()
    {
        return $this->hasMany(\common\models\DashboardGiplet::className(), ['giplet_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGipletType()
    {
        return $this->hasOne(\common\models\GipletType::className(), ['id' => 'giplet_type_id']);
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
     * @return \common\models\query\GipletQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\GipletQuery(get_called_class());
    }
}
