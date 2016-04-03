<?php

namespace common\models\base;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the base model class for table "giplet_type".
 *
 * @property integer $id
 * @property string $name
 * @property string $display_name
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property string $factory
 *
 * @property \common\models\Giplet[] $giplets
 * @property \common\models\Giplet1[] $giplet1s
 */
class GipletType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'display_name'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
            [['name', 'display_name'], 'string', 'max' => 40],
            [['description'], 'string', 'max' => 2000],
            [['factory'], 'string', 'max' => 80],
            [['name'], 'unique'],
            [['display_name'], 'unique']
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'giplet_type';
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
            'factory' => Yii::t('gip', 'Factory'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGiplets()
    {
        return $this->hasMany(\common\models\Giplet::className(), ['giplet_type_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGiplet1s()
    {
        return $this->hasMany(\common\models\Giplet1::className(), ['giplet_type_id' => 'id']);
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
     * @return \common\models\query\GipletTypeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\GipletTypeQuery(get_called_class());
    }
}
