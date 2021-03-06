<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace common\models\base;

use Yii;

/**
 * This is the base-model class for table "subscription".
 *
 * @property integer $id
 * @property integer $service_id
 * @property integer $rule_id
 * @property integer $enabled
 * @property integer $trusted
 * @property string $name
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $provider_id
 *
 * @property \common\models\Service $service
 * @property \common\models\Rule $rule
 * @property \common\models\Provider $provider
 */
abstract class Subscription extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'subscription';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['service_id', 'rule_id', 'enabled', 'trusted', 'name', 'provider_id'], 'required'],
            [['service_id', 'rule_id', 'enabled', 'trusted', 'created_by', 'updated_by', 'provider_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 40],
            [['display_name'], 'string', 'max' => 80],
            [['description'], 'string', 'max' => 2000],
            [['name'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('gip', 'ID'),
            'service_id' => Yii::t('gip', 'Service'),
            'rule_id' => Yii::t('gip', 'Rule'),
            'enabled' => Yii::t('gip', 'Enabled'),
            'trusted' => Yii::t('gip', 'Trusted'),
            'name' => Yii::t('gip', 'Name'),
            'display_name' => Yii::t('gip', 'Display Name'),
            'description' => Yii::t('gip', 'Description'),
            'created_at' => Yii::t('gip', 'Created At'),
            'updated_at' => Yii::t('gip', 'Updated At'),
            'created_by' => Yii::t('gip', 'Created By'),
            'updated_by' => Yii::t('gip', 'Updated By'),
            'provider_id' => Yii::t('gip', 'Provider'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getService()
    {
        return $this->hasOne(\common\models\Service::className(), ['id' => 'service_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRule()
    {
        return $this->hasOne(\common\models\Rule::className(), ['id' => 'rule_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProvider()
    {
        return $this->hasOne(\common\models\Provider::className(), ['id' => 'provider_id']);
    }




}
