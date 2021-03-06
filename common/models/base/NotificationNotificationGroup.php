<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace common\models\base;

use Yii;

/**
 * This is the base-model class for table "notification_notification_group".
 *
 * @property integer $id
 * @property integer $notification_group_id
 * @property integer $notification_id
 * @property string $created_at
 * @property string $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property \common\models\NotificationGroup $notificationGroup
 * @property \common\models\Notification $notification
 */
abstract class NotificationNotificationGroup extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'notification_notification_group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['notification_group_id', 'notification_id'], 'required'],
            [['notification_group_id', 'notification_id', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('gip', 'ID'),
            'notification_group_id' => Yii::t('gip', 'Notification Group'),
            'notification_id' => Yii::t('gip', 'Notification'),
            'created_at' => Yii::t('gip', 'Created At'),
            'updated_at' => Yii::t('gip', 'Updated At'),
            'created_by' => Yii::t('gip', 'Created By'),
            'updated_by' => Yii::t('gip', 'Updated By'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNotificationGroup()
    {
        return $this->hasOne(\common\models\NotificationGroup::className(), ['id' => 'notification_group_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNotification()
    {
        return $this->hasOne(\common\models\Notification::className(), ['id' => 'notification_id']);
    }




}
