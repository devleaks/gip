<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace common\models\base;

use Yii;

/**
 * This is the base-model class for table "processing".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $service_id
 * @property integer $provider_id
 * @property integer $event_id
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property \common\models\Mapping[] $mappings
 * @property \common\models\Service $service
 * @property \common\models\Provider $provider
 * @property \common\models\Event $event
 */
abstract class Processing extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'processing';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'service_id', 'provider_id', 'event_id'], 'required'],
            [['service_id', 'provider_id', 'event_id', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 40],
            [['description'], 'string', 'max' => 2000],
            [['status'], 'string', 'max' => 20],
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
            'name' => Yii::t('gip', 'Name'),
            'description' => Yii::t('gip', 'Description'),
            'service_id' => Yii::t('gip', 'Service ID'),
            'provider_id' => Yii::t('gip', 'Provider ID'),
            'event_id' => Yii::t('gip', 'Event ID'),
            'status' => Yii::t('gip', 'Status'),
            'created_at' => Yii::t('gip', 'Created At'),
            'updated_at' => Yii::t('gip', 'Updated At'),
            'created_by' => Yii::t('gip', 'Created By'),
            'updated_by' => Yii::t('gip', 'Updated By'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMappings()
    {
        return $this->hasMany(\common\models\Mapping::className(), ['processing_id' => 'id']);
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
    public function getProvider()
    {
        return $this->hasOne(\common\models\Provider::className(), ['id' => 'provider_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvent()
    {
        return $this->hasOne(\common\models\Event::className(), ['id' => 'event_id']);
    }




}
