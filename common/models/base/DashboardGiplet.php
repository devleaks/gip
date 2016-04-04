<?php

namespace common\models\base;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the base model class for table "dashboard_giplet".
 *
 * @property integer $id
 * @property integer $dashboard_id
 * @property integer $giplet_id
 * @property integer $row_number
 * @property integer $position
 * @property string $created_at
 * @property string $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property \common\models\Dashboard $dashboard
 * @property \common\models\Giplet $giplet
 */
class DashboardGiplet extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dashboard_id', 'giplet_id'], 'required'],
            [['dashboard_id', 'giplet_id', 'row_number', 'position', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe']
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dashboard_giplet';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('gip', 'ID'),
            'dashboard_id' => Yii::t('gip', 'Dashboard'),
            'giplet_id' => Yii::t('gip', 'Giplet'),
            'row_number' => Yii::t('gip', 'Row Number'),
            'position' => Yii::t('gip', 'Position'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDashboard()
    {
        return $this->hasOne(\common\models\Dashboard::className(), ['id' => 'dashboard_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGiplet()
    {
        return $this->hasOne(\common\models\Giplet::className(), ['id' => 'giplet_id']);
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
     * @return \common\models\query\DashboardGipletQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\DashboardGipletQuery(get_called_class());
    }
}
